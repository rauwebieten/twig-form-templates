<?php

namespace rauwebieten\twigformtemplates;

use Twig\Environment;
use Twig\Loader\ChainLoader;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigFormTemplates
{
    public $optionalLabel = '(optional)';

    public function registerTemplates(Environment $environment)
    {
        $loader = new FilesystemLoader();
        $loader->addPath(__DIR__ . '/templates', 'form');

        $loader = new ChainLoader([$environment->getLoader(), $loader]);
        $environment->setLoader($loader);

        $environment->addFilter(new TwigFilter('tft_parameters_merge', [$this, 'parametersMerge']));
        $environment->addFunction(new TwigFunction('tft_optional_label', [$this, 'optionalLabel']));
        $environment->addFilter(
            new TwigFilter('tft_attribute_string', [$this, 'attributeString'], ['is_safe' => ['html']])
        );
    }

    public function optionalLabel() :string{
        return $this->optionalLabel;
    }

    public function attributeString($attributes): string
    {
        $attributesString = '';
        foreach ($attributes as $k => $v) {
            if (is_bool($v)) {
                $attributesString .= "$k ";
            } elseif (is_array($v)) {
                $v = implode(" ", $v);
                $attributesString .= "$k=\"$v\" ";
            } else {
                $attributesString .= "$k=\"$v\" ";
            }
        }
        $attributesString = trim($attributesString);

        return $attributesString;
    }

    public function parametersMerge($a, $b): array
    {
        $result = array_merge($a, $b);
        $result['attributes'] = array_merge($a['attributes'], $b['attributes']);
        $result['class'] = trim($a['class'] . ' ' . $b['class']);
        return $result;
    }
}