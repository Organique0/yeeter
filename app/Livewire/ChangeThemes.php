<?php

namespace App\Livewire;

use Livewire\Component;

class ChangeThemes extends Component
{
    public bool $showDrawer = false;
    public array $themes = [
        "light",
        "dark",
        "cupcake",
        "bumblebee",
        "emerald",
        "corporate",
        "synthwave",
        "retro",
        "cyberpunk",
        "valentine",
        "halloween",
        "garden",
        "forest",
        "aqua",
        "lofi",
        "pastel",
        "fantasy",
        "wireframe",
        "black",
        "luxury",
        "dracula",
        "cmyk",
        "autumn",
        "business",
        "acid",
        "lemonade",
        "night",
        "coffee",
        "winter",
        "dim",
        "nord",
        "sunset",
    ];

    public string $type = "";
    public function mount($type)
    {
        $this->type = $type;
    }

    public function getFormattedThemesProperty()
    {
        return array_map(function ($theme, $index) {
            return [
                'id' => $index + 1,
                'value' => $theme,
                'name' => ucfirst($theme)
            ];
        }, $this->themes, array_keys($this->themes));
    }

    public function render()
    {
        return view('livewire.change-themes', [
            'formattedThemes' => $this->formattedThemes,
            'type' => $this->type
        ]);
    }
}
