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
        $this->published = date('l jS \of F Y h:i:s A');
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
        $textf = empty($this->slug);

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


abstract class Storage{
    abstract protected function create (TelegraphText $telegraphText);

    abstract protected function read($slug):TelegraphText;
    abstract protected function update($slug , $newobject);
    abstract protected function delete($slug);
    abstract protected function list():array;

}
abstract class User{
    public $id;
    public $name;
    public $role;
    abstract protected function getTextsToEdit();
}


class FileStorage  extends Storage{

    protected function create(TelegraphText $telegraphText)
    {
        $serobject = serialize($telegraphText);

        if (file_exists($telegraphText->slug)){
            $i =1;
            while (true){

                $slug = $telegraphText->slug . '_' . $i;
                if (file_exists($slug)) { $i++;
                    continue;
                } else {
                    file_put_contents($telegraphText->slug , $serobject);
                    break;
                }

            }


        } else {
            file_put_contents($telegraphText->slug , $serobject);
        }


    }

    protected function read($slug): TelegraphText
    {
        $textf = file_get_contents ($slug);
        $object = unserialize($textf);
        return $object;
    }

    protected function update($slug, $newobject)
    {
        $serrobject = serialize($newobject);
        file_put_contents($slug , $serrobject);

    }

    protected function delete($slug)
    {
        unlink($slug);
    }

    protected function list(): array
    {
        $arr = scandir('/test');
        foreach ($arr as $value) {
            $textf = file_get_contents($value);
            $unserobjeckt = unserialize($textf);
            $arr[] = $unserobjeckt;
        }
        return $arr;
    }
}
