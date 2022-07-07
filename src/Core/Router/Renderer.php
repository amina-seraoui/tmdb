<?php

namespace App\Core\Router;

class Renderer
{
    private string $dir_path = ROOT . '/src/views/';
    public function __construct() {}

    public function render(string $view, array $params = []): string
    {
        // Transformer le tableau de variables en variables
        extract($params);

        // Récupérer le contenu
        ob_start();
        require $this->dir_path . $view . '.php';
        $content = ob_get_clean();

        // L'afficher dans le layout
        ob_start();
        require $this->dir_path . '_layout.php';
        return ob_get_clean();
    }
}
