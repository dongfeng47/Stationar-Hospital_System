<?php
class LangController
{
    public function switch($lang)
    {
        $allowed = ['ru', 'kg'];
        if (in_array($lang, $allowed)) {
            $_SESSION['lang'] = $lang;
        }
        header('Location: index.php');
        exit;
    }
}
