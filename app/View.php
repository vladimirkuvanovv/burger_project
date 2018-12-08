<?php

namespace App;


use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class View
 * @package App
 */
final class View
{
    /**
     * @var Twig_Environment
     */
    private $twig;
    /**
     * @var Twig_Loader_Filesystem
     */
    private $loader;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem(__DIR__.'/../Resourses/Views');
        $this->twig = new Twig_Environment($this->loader);
    }


    /**
     * @param $twigView
     * @param array $data
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return mixed
     */
    public function render($twigView, $data = [])
    {
        echo $this->twig->render($twigView.'.twig', $data);

        return;
    }
}