<?php

namespace App\Jobs;

use App\Models\File as FileModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckFileMoved implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileId;
    protected $postId;
    protected $filename;
    protected $attempts;

    public function __construct($fileId, $postId, $filename, $attempts = 0)
    {
        $this->fileId = $fileId;
        $this->postId = $postId;
        $this->filename = $filename;
        $this->attempts = $attempts;
    }

    //Moramo si zapomniti, da je ta job ponavadi izvede po tem, ko je bila Lambda sprožena
    //Zato je obdelan video posnetek že naložen v yeetMedia mapo
    public function handle(): void
    {
        $maxAttempts = 5;
        $delaySeconds = 3;

        $s3 = Storage::disk("s3");
        //to je glavna mapa z obdelanimi video posnetki in slikami
        //id posta je seveda pod mapa in v mapi je datoteka z določenim imenom
        //to vse generira Lambda
        $newPath = "yeetMedia/" . $this->postId . "/" . $this->filename;

        //preverimo, če je Lambda že kopirala video v yeetMedia mapo
        if ($s3->exists($newPath)) {
            //dobimo url naslov tega video posnetka
            $newUrl = $s3->url($newPath);

            //tabela files že vsebuje nov zapis
            //mi ga moramo samo najti s pomočjo id-ja
            $fileModel = FileModel::find($this->fileId);
            //če ga najdemo, potem temu zapisu posodobimo url atribut na nov url
            //prejšnji je kazal na upload-original mapo, iz katere je že izbrisan
            if ($fileModel) {
                $fileModel->url = $newUrl;
                $fileModel->save();
            }
            //to samo ponavlja to funkcijo, v primeru če Lambda še ni končala
            //to se dogaja tolikokrat kot je vrednost $maxAttempts
            //$delaySeconds doda, koliko časa po tem, ko je bila poklicana dispatch funkcija, se izvede ta job
        } elseif ($this->attempts < $maxAttempts) {
            $this->attempts++;
            self::dispatch(
                $this->fileId,
                $this->postId,
                $this->filename,
                $this->attempts
            )->delay(now()->addSeconds($delaySeconds));
        }
    }
}
