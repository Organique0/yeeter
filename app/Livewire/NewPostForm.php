<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\File as FileModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\CheckFileMoved;
use Illuminate\Support\Facades\App;

class NewPostForm extends Component
{
    use WithFileUploads;

    #[Rule(["files.*" => "mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi|max:10240"])]
    public array $files = [];

    #[Rule("required")]
    public string $message = "";
    public mixed $fileSystemDisk;

    //env, ki določi kam se shranijo datoteke
    //mora biti tukaj ali v save(). Ampak tukaj se zdi lepše
    public function __construct()
    {
        $this->fileSystemDisk = env('FILESYSTEM_DISK');
    }

    public function save(): void
    {
        $this->validate();

        $post = Post::create([
            "user_id" => auth()->id(),
            "message" => $this->message,
        ]);

        //če ni priloženih datotek, potem samo shrani post in pošlje event
        if (empty($this->files)) {
            $this->dispatch("postCreated");
            $this->reset(["message", "files"]);
            return;
        }

        foreach ($this->files as $file) {
            $mimeType = $file->getMimeType();
            $type = Str::startsWith($mimeType, "image") ? "image" : "video";

            //yes, I just love to waste as much time as possible
            //now, you upload the images locally when you are developing
            //and when you are in production, you upload them to s3
            if ($this->fileSystemDisk == 'public') {

                if ($type === "image") {
                    $path = $file->store('images', 'public');
                } else {
                    $path = $file->store('videos', 'public');
                }

                FileModel::create([
                    "post_id" => $post->id,
                    "url" => $path,
                    "type" => $type,
                ]);
            } else if ($this->fileSystemDisk == 's3') {
                //če je navadna slika, potem jo samo shrani v yeetMedia datoteko
                //yeetMedia je mapa v s3 bucketu
                //id posta je pod-mapa v katero se shranjijo slike in videi
                //getClientOriginalName() dobi originalno ime naložene datoteke (enako ime, kot je bilo ime datoteki, ki je bila naložena iz brskalnika)
                if ($type === "image") {
                    $path = $file->storeAs(
                        "yeetMedia/" . $post->id,
                        $file->getClientOriginalName(),
                        "s3"
                    );

                    //Dobi url naložene slike
                    $url = Storage::disk("s3")->url($path);

                    //V bazo shrani nov zapis v tabelo files
                    $fileModel = FileModel::create([
                        "post_id" => $post->id,
                        "url" => $url,
                        "type" => $type,
                    ]);
                }

                //če naložimo video, potem gre malo drugače
                //tokrat naloži datoteke v upload-original mapo v s3 bucketu
                //ko je datoteka naložena tja, se avtomatično pokliče Lambda funkcija, ki ta video obdela, ga kopira v yeetMedia mapo na s3, ter ga izbriše iz upload-original mape
                if ($type === "video") {
                    $path = $file->storeAs(
                        "upload-original/" . $post->id,
                        $file->getClientOriginalName(),
                        "s3"
                    );

                    $url = Storage::disk("s3")->url($path);

                    $fileModel = FileModel::create([
                        "post_id" => $post->id,
                        "url" => $url,
                        "type" => $type,
                    ]);

                    //ok, to je še bolj zanimiv del.
                    //problem z mojo implementacijo je bil, da ko uporabnik naloži datoteko, brskalnik zamrzne dokler lambda ne obdela video posnetka
                    //to je rešeno z tem, da uporabimo Jobs, kar je Laravel funkcionalnost
                    //Livewire file upload ima vgrajeno tudi to, da avtomatično naloži datoteko v začasno mapo na s3
                    //Uporabniko se zato takoj prikaže predogled naložene slike v obrazcu.
                    //Vendar pa lahko to sliko iz temp mape tudi uporabimo zato, da jo prikažemo kot "placeholder" na novo narejenem postu
                    //Medtem pa se v ozadju izvede ta job.
                    //Ko se objave posodobijo, se začasni url slike zamenja z sliko, ki jo naloži ta job.
                    CheckFileMoved::dispatch(
                        $fileModel->id,
                        $post->id,
                        $file->getClientOriginalName()
                    )->delay(now()->addSeconds(3));
                }
            }
        }

        $this->dispatch("postCreated");
        $this->reset(["message", "files"]);
    }

    public function render(): View
    {
        return view("livewire.new-post-form");
    }
}
