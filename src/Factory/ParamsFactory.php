<?php
namespace Eddy\Robots\Factory;

class ParamsFactory
{
    private function prepareParam(string $param)
    {
        return array_map(fn($bit) => trim($bit), explode(':', $param, 2));
    }

    public function make(array $params)
    {
        $options = [
            'sitemap' => null,
            'allow' => [],
            'disallow' => [],
            'host' => [],
            'crawl-delay' => null
        ];

        foreach ($params as $param) {
            [$key, $val] = $this->prepareParam($param);
            $lc = strtolower($key);
            if ($lc === 'sitemap' || $lc === 'crawl-delay') {
                $options[$lc] = $val;
            } else if (isset($options[$lc])) {
                array_push($options[$lc], $val);
            }
        }
        // dd($options, $params);
        return $options;
    }
}
