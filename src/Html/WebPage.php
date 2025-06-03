<?php

declare(strict_types=1);

namespace Html;

class WebPage
{
    use StringEscaper;
    private string $head = "";
    private string $title = "";
    private string $body = "";

    /**
     * Initialise un nouveau élément
     * @param string $title Le titre de la page
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    /**
     * Récupère la date de la dernière modification du script
     *
     * @return string La date en question
     */
    public static function getLastModification(): string
    {
        return date("d/m/o - H:i", getlastmod());
    }

    /**
     * Ajoute du contenu au corps de la page
     *
     * @param string $content Le contenu à ajouter
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     *  Ajoute du css à la page web
     *
     * @param string $css Le css à ajouter
     * @return void
     */
    public function appendCss(string $css): void
    {
        $this->appendToHead("\n\t<style>\n$css\n\t</style>");
    }

    /**
     * Ajoute du code HTML dans l'entête
     *
     * @param string $content Le code à ajouter
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Ajoute un lien vers un fichier de style css
     *
     * @param string $url Le lien vers le fichier de style css
     * @return void
     */
    public function appendCssUrl(string $url): void
    {
        $this->appendToHead("<link href=\"$url\" rel='stylesheet'>");
    }

    /**
     *  Ajoute du script javascript à la page web
     *
     * @param string $js Le script à ajouter
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->appendToHead("\n\t<script>\n$js\n\t</script>");
    }

    /**
     * Ajoute un script externe la page
     *
     * @param string $url Le lien vers le script en question
     * @return void
     */
    public function appendJsUrl(string $url): void
    {
        $this->appendToHead("\n\t<script type='text/javascript' src=\"$url\"></script>");
    }



    /**
     * Génère la page web complète
     * @return string La page web complète
     */
    public function toHTML(): string
    {
        $lastmod = WebPage::getLastModification();
        $html = <<< HTML
        <!doctype html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <title>{$this->getTitle()}</title>
                {$this->getHead()}
            </head>
            <body>
                {$this->getBody()}
            <footer style="position: relative;bottom: 0;width: 100%;height: 2.5rem; ">Date de dernière modification : $lastmod</footer>
            </body>
            
        HTML;


        return $html;
    }

    /**
     * Récupère le titre de la page
     * @return string Le titre de la page
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Change le titre de la page
     *
     * @param string $title Le nouveau titre de la page
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Récupère l'entête générée de la page web
     * @return string L'entête de la page web
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Récupère le corps généré de la page
     * @return string Le corps de la page web
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
