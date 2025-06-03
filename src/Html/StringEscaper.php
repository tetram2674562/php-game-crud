<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    /**
     * Remplace les caractères spéciaux pouvant dégrader la page Web.
     *
     * @param string|null $text Une chaîne de caractères non protégés
     * @return string Une chaîne de caractères protégés
     */
    public function escapeString(?string $text): string
    {
        if ($text == null) {
            $new_str = "";
        } else {
            $new_str = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE | ENT_DISALLOWED | ENT_HTML5);
        }
        return $new_str;
    }

    /**
     * Supprime les balises et les espaces au début et à la fin de la chaine de caractère.
     * @param string|null $text Un texte
     * @return string Le texte sans balises et sans espaces.
     */
    public function stripTagsAndTrim(?string $text): string
    {
        if ($text == null) {
            $new_str = "";
        } else {
            $new_str = trim(strip_tags($text));
        }
        return $new_str;
    }
}
