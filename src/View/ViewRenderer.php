<?php

namespace App\View;

class ViewRenderer
{
    private string $templatesDir;

    public function __construct(string $templatesDir)
    {
        $this->templatesDir = realpath($templatesDir);
    }

    public function render(string $template, array $data = []): string
    {
        $file = $this->templatesDir . '/' . $template . '.php';
        if (!file_exists($file)) {
            // Try to load a generic 'notfound' template
            $notFoundFile = $this->templatesDir . '/notfound.php';
            if (file_exists($notFoundFile)) {
                extract($data);
                ob_start();
                include $notFoundFile;
                return ob_get_clean();
            }
            // If even the notfound template is missing
            return "<pre>Template '{$template}' not found and no 'notfound' fallback exists.</pre>";
        }

        extract($data);
        // Start output buffering to capture the output of the included file
        // and return it as a string
        // This allows us to use the template as a string
        // instead of directly outputting it
        ob_start();
        include $file;
        return ob_get_clean();
    }
}