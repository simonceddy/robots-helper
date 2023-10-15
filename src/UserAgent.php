<?php
namespace Eddy\Robots;

/**
 * The UserAgent class represents a User-agent section in a robots.txt file.
 * 
 * @property string[] $host
 * @property string[] $hosts
 * @property string[] $allow
 * @property string[] $allowed
 * @property string[] $disallow
 * @property string[] $disallowed
 * @property string|int|null $delay
 * @property string|int|null $crawlDelay
 * @property string|null $sitemap
 */
class UserAgent
{
    private array $allowedPaths = [];

    private array $disallowedPaths = [];

    private ?string $agentSitemap = null;

    private array $hostList = [];

    private mixed $crawlDelay = null;

    public function __construct(private string $agent = '*', array $options = [])
    {
        if (!empty($options)) {
            // TODO validate
            $this->initOptions($options);
        }
    }
    
    private function initOptions(array $options)
    {
        $this->agentSitemap = $options['Sitemap'] ?? $options['sitemap'] ?? null;
        $this->crawlDelay = $options['Crawl-Delay']
            ?? $options['crawl-delay']
            ?? $options['crawlDelay']
            ?? $options['delay']
            ?? $options['Delay']
            ?? null;
        $a = $options['Allow']
            ?? $options['allow']
            ?? $options['Allowed']
            ?? $options['allowed']
            ?? null;
        if ($a) {
            $this->allowedPaths = $a;
        }
        $d = $options['Disallow']
            ?? $options['disallow']
            ?? $options['Disallowed']
            ?? $options['disallowed']
            ?? null;
    
        if ($d) {
            $this->disallowedPaths = $d;
        }
        $h = $options['Host']
            ?? $options['host']
            ?? $options['hosts']
            ?? $options['Hosts']
            ?? null;
    
        if ($h) {
            $this->hostList = $h;
        }
    }

    /**
     * Get the user agent
     *
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set the user agent
     *
     * @param string $agent
     *
     * @return self
     */
    public function setAgent(string $agent)
    {
        $this->agent = $agent;
        return $this;
    }
    
    /**
     * Get the crawl delay for the user agent
     *
     * @return string|int|null
     */
    public function getCrawlDelay()
    {
        return $this->crawlDelay ?? null;
    }

    /**
     * Set the crawl delay for the user agent
     *
     * @param string|int $agent
     *
     * @return self
     */
    public function setCrawlDelay(mixed $delay)
    {
        $this->crawlDelay = $delay;
        return $this;
    }

    /**
     * Get hosts for the User Agent
     *
     * @param int|null $key Find a specific host by array key 
     *
     * @return string[]|string|null
     */
    public function getHosts(?int $key = null)
    {
        if ($key !== null) return $this->hostList[$key] ?? null;
        return $this->hostList;
    }

    /**
     * Add hosts to the User Agent
     *
     * @param string|string[] $host
     *
     * @return self
     */
    public function addHost(mixed $host)
    {
        if (is_string($host)) $host = [$host];
        else if (!is_array($host)) {
            throw new \InvalidArgumentException(
                'Hosts must be a string or an array of strings!'
            );
        }
        array_push($this->hostList, ...$host);
        return $this;
    }

    /**
     * Get allowed paths for the User Agent
     *
     * @param int|null $key Find a specific path by array key 
     *
     * @return string[]|string|null
     */
    public function getAllowed(?int $key = null)
    {
        if ($key !== null) return $this->allowedPaths[$key] ?? null;
        return $this->allowedPaths;
    }

    /**
     * Add allowed paths to the User Agent
     *
     * @param string|string[] $path
     *
     * @return self
     */
    public function addAllowed(mixed $path)
    {
        if (is_string($path)) $path = [$path];
        else if (!is_array($path)) {
            throw new \InvalidArgumentException(
                'Paths must be a string or an array of strings!'
            );
        }
        array_push($this->allowedPaths, ...$path);
        return $this;
    }

    /**
     * Add disallowed paths to the User Agent
     *
     * @param string|string[] $path
     *
     * @return self
     */
    public function addDisallowed(mixed $path)
    {
        if (is_string($path)) $path = [$path];
        else if (!is_array($path)) {
            throw new \InvalidArgumentException(
                'Paths must be a string or an array of strings!'
            );
        }
        array_push($this->disallowedPaths, ...$path);
        return $this;
    }


    /**
     * Get disallowed paths for the User Agent
     *
     * @param int|null $key Find a specific path by array key 
     *
     * @return string[]|string|null
     */
    public function getDisallowed(?int $key = null)
    {
        if ($key !== null) return $this->disallowedPaths[$key] ?? null;
        return $this->disallowedPaths;
    }

    /**
     * Get the user agent sitemap if set
     *
     * @return string|null
     */
    public function getSitemap()
    {
        return $this->agentSitemap ?? null;
    }

    /**
     * Set the User Agent sitemap
     *
     * @param string $path
     *
     * @return self
     */
    public function setSitemap(string $path)
    {
        $this->agentSitemap = $path;
        return $this;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'host':
            case 'hosts':
                return $this->hostList;
            case 'allow':
            case 'allowed':
                return $this->allowedPaths;
            case 'disallow':
            case 'disallowed':
                return $this->disallowedPaths;
            case 'sitemap':
                return $this->agentSitemap;
            case 'delay':
            case 'crawlDelay':
                return $this->crawlDelay;
            default:
        }

        throw new \OutOfBoundsException(
            'Undefined property: ' . $name
        );
    }
    
    public function __set($name, $val)
    {
        switch ($name) {
            case 'host':
            case 'hosts':
                return $this->addHost($val);
            case 'allow':
            case 'allowed':
                return $this->addAllowed($val);
            case 'disallow':
            case 'disallowed':
                return $this->addDisallowed($val);
            case 'sitemap':
                return $this->setSitemap($val);
            case 'delay':
            case 'crawlDelay':
                return $this->setCrawlDelay($val);
            default:
        }

        throw new \OutOfBoundsException(
            'Undefined property: ' . $name
        );
    }

    /**
     * Render the User Agent to text for robots.txt
     *
     * @return string
     */
    public function toString()
    {
        $lines = [
            'User-agent: ' . $this->agent,
        ];

        foreach ($this->hostList as $host) {
            array_push($lines, 'Host: ' . $host);
        }

        foreach ($this->disallowedPaths as $disallow) {
            array_push($lines, 'Disallow: ' . $disallow);
        }

        foreach ($this->allowedPaths as $allow) {
            array_push($lines, 'Allow: ' . $allow);
        }
        if ($this->agentSitemap) {
            array_push($lines, 'Sitemap: ' . $this->agentSitemap);
        }
        return implode("\n", $lines);
    }

    public function __toString()
    {
        return $this->toString();
    }
}
