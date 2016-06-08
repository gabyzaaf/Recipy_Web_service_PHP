<?php

namespace Recipy\Extension\Twig;

use Symfony\Component\HttpFoundation\Request;
use Twig_Extension;

/**
 * Class Page
 * @package Recipy\Extension\Twig
 */
class Page extends Twig_Extension
{
    /** @var Request */
    protected $request;

    /**
     * Page constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions() : array
    {
        return [
            new \Twig_SimpleFunction('isSection', [$this, 'isSection']),
            new \Twig_SimpleFunction('hasSection', [$this, 'hasSection'])
        ]; 
    }

    /**
     * @param string|null $section
     *
     * @return bool
     */
    public function isSection(string $section = null) : bool
    {
        return $this->request->query->get('section') == $section;
    }

    /**
     * @return bool
     */
    public function hasSection() : bool
    {
        return !!($this->request->query->get('section') ?? false);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() : string
    {
        return 'page';
    }
}
