<?php


class TelegraphText
{
    private string $text;
    private string $title;
    private string $author;
    private string $published;
    private string $slug;

    public function __construct($author, $slug)
    {
        $this->author = $author;
        $this->slug = $slug;
        $this->published = '18.02.24  15:00';
    }

    public function storeText()
    {
        $array = ['author' => $this->author,
            'text' => $this->text,
            'title' => $this->title,
            'published' => $this->published];
        $serrarr = serialize($array);
        file_put_contents($this->slug, $serrarr);
    }


    public function loadText()
    {
        $textf = file_get_contents($this->slug);

        if ($textf == !'') {
            $array = unserialize($textf);
            $array['author'] = $this->author;
            $array['text'] = $this->text;
            $array['published'] = $this->published;
            $array['title'] = $this->title;

        };
        return $this->text;

    }

    public function editText($title, $text)
    {
        $this->title = $title;
        $this->text = $text;

    }

}

$telegraphtext = new TelegraphText('artemka', 'php');
//var_dump($telegraphtext);
$telegraphtext->editText('zadacha', 'Module8');
$telegraphtext->storeText();
$remote = $telegraphtext->loadText();
var_dump($remote);