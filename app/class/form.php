<?php

/**
 * Class Form
 * 
 * Permet de générer le code HTML d'un formulaire
 */
class Form
{
    /**
     * @var string Contient l'ensemble du code HTML
     */
    private string $html;

    /**
     * Ouvre les balises structurelles du formulaire
     * @param string $action L'URL de destination du formulaire
     * @param string $method La méthode POST
     */
    public function __construct(string $action, string $method = "post")
    {
        $this->html = "<form action=\"$action\" method=\"$method\">\n";
    }

    /**
     * Crée une balise label et un input du type text à l'intérieur d'un paragraphe
     *
     * @param string $name Le nom de l'attribut
     * @param string $label La description affichée pour l'utilisateur
     * @param string $type Le type d'input (text, password, email, etc.).
     * @return void
     */
    public function setInput(string $name, string $label, string $type): void
    {
        $this->html .= "<p>";
        $this->html .= "<label for =\"$name\">$label</label>\n";
        $this->html .= "<input type = \"$type\" name =\"$name\" id=\"$name\">";
        $this->html .= "</p>";
    }

    /**
     * Crée un textarea pour les contenus longs (récits, commentaires)
     *  @param string $name Le nom de l'attribut
     *  @param string $label La description affichée pour l'utilisateur
     * @return void
     */
    public function setTextarea(string $name, string $label, int $rows): void
    {
        $this->html .= "<p>";
        $this->html .= "<label for=\"$name\">$label</label>\n";
        $this->html .= "<textarea name=\"$name\" id=\"$name\" rows=\"$rows\"></textarea>";
        $this->html .= "</p>";
    }
    /**
     * Ajoute un message d'erreur au formulaire
     * @param string $message Le texte de l'erreur
     */
    public function setError(string $message = ""): void
    {
        if (!empty($message)) {
            $this->html .= "<p class=\"error-message\"\>";
            $this->html .= $message;
            $this->html .= "</p>\n";
        }
    }

    /**
     * Ajoute un paragraphe de texte au formulaire.
     * @param string $text Le contenu du texte.
     * @param string $class classe CSS.
     */
    public function setText(string $text, string $class = ""): void
    {
        $this->html .= "<p class='$class'>$text</p>";
    }
    /**
     * Ajoute un lien au formulaire.
     * @param string $href L'URL.
     * @param string $text Le texte du lien.
     * @param string $class classe CSS.
     */
    public function setLink(string $href, string $text, string $class = ""): void
    {
        $this->html .= "<a href='$href' class='$class'>$text</a>";
    }

    /**
     * Crée un paragraphe avec un input du type submit intérieur
     * @param string $value la value du input
     * @return void
     */
    public function setSubmit(string $value): void
    {
        $this->html .= "<p>\n";
        $this->html .= "<input type=\"submit\" value=\"$value\">\n";
        $this->html .= "</p>\n";
    }

    /**
     * Ferme les balises structurelles du formulaire
     * @return string formulaire crée
     */
    public function getForm(): string
    {
        $form = $this->html;
        $form .= "</form>";

        return $form;
    }
}
