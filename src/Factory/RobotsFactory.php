<?php
namespace Eddy\Robots\Factory;

use Eddy\Robots\Robots;
use Eddy\Robots\UserAgent;

class RobotsFactory
{
    public function __construct(
        private UserAgentFactory $userAgentFactory,
    ) {}

    /**
     * Create a Robots object from the contents of a robots.txt file
     *
     * @param string $contents
     *
     * @return void
     */
    public function make(string $contents)
    {
        $bits = [...array_filter(explode("\n", $contents), function($bit) {
            if (preg_match('/^\#\s?/', $bit)) return false;
            return strlen(trim($bit)) > 0;
        })];
        // dd($bits);
        $agents = array_filter($bits, function($bit) {
            return str_starts_with(strtolower($bit), 'user-agent');
        });

        if (empty($agents)) {
            // TODO
            return new Robots([]);
        }
        $startId = null;
        $endId = null;
        $lastAgent = null;
        // dd($agents);
        $agentObjects = [];
        if (count($agents) === 1) {
            $ag = $this->userAgentFactory->make($bits);
            $agentObjects[$ag->getAgent()] = $ag;
            // dd($bits);
        } else {
            foreach ($agents as $id => $str) {
                if (isset($startId)) {
                    $endId = $id;
                    $params = array_slice($bits, $startId + 1, $endId - $startId - 1);
                    $ag = $this->userAgentFactory->make($params, $lastAgent);
                    
                    $agentObjects[$ag->getAgent()] = $ag;
                } 
                $startId = $id;
                $agent = trim(preg_replace('/^User\-A?a?gent\:\s?/', '', $str));
        
                $lastAgent = $agent;
                // dd($agent);
            }
            if ($lastAgent !== array_key_last($agentObjects) && $startId !== null) {

                $t = count($bits);
                $params = array_slice($bits, $startId + 1, $t - $startId - 1);
                $ag = $this->userAgentFactory->make($params, $lastAgent);
                
                $agentObjects[$ag->getAgent()] = $ag;
            }
        }
        // dd($agentObjects);
        return new Robots($agentObjects);
    }
}
