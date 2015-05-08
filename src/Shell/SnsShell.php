<?php
namespace App\Shell;

require APP . 'Vendor' . DS . 'aws' . DS . 'autoload.php';
require APP . 'Lib' . DS . 'Aws' . DS . 'Sns' . DS . 'autoload.php';

use Cake\Console\Shell;
use Cake\Log\Log;
use Lib\Aws\Sns;

/**
 * Push notification message to the endpoints shell using AWS SNS
 *
 */
class SnsShell extends Shell
{
    private $Wrapper;

    public function initialize()
    {
        parent::initialize();

        // Config logging
        Log::config('aws_sns', [
            'className' => 'Cake\Log\Engine\FileLog',
            'path' => LOGS,
            'levels' => [],
            'scopes' => ['endpoint'],
            'file' => 'aws_sns.log',
        ]);

        $this->Wrapper = new \Lib\Aws\Sns\Wrapper();
    }

    public function listPlatformApplications()
    {
        $result = $this->Wrapper->listPlatformApplications();
        $this->out("List Platform Applications:");
        $this->out(pr($result));
    }

    public function getPlatformApplicationAttributes($platformApplicationArn = '')
    {
        $result = $this->Wrapper->getPlatformApplicationAttributes($platformApplicationArn);
        $this->out("Appication $platformApplicationArn Attributes:");
        $this->out($result);
    }

    public function listEndpointsByPlatformApplication($platformApplicationArn = '')
    {
        $result = $this->Wrapper->listEndpointsByPlatformApplication($platformApplicationArn);
        $this->out("List Endpoints of {$platformApplicationArn}:");
        $this->out(pr($result));
    }

    public function listEndpoints()
    {
        $result = $this->Wrapper->listEndpoints();
        $this->out("List Endpoints:");
        $this->out($result);
    }

    public function deleteEndpoint($endpointArn = '')
    {
        $result = $this->Wrapper->deleteEndpoint($endpointArn);
        $this->out("Delete {$endpointArn}:");
        $this->out($result);
    }

    public function createTopic($topicName = '')
    {
        $result = $this->Wrapper->createTopic($topicName);
        $this->out("Create Topic \"{$topicName}\":");
        $this->out($result);
    }

    public function listTopics()
    {
        $listTopics = $this->Wrapper->listTopics();
        $this->out('List Topics:');
        $this->out($listTopics);
    }

    public function subscribe($topicArn = '', $endpointArn = '', $protocol = 'application')
    {
        $listEndpointArns = json_decode($endpointArn, true);
        if ($listEndpointArns) { // Multiple case
            $result = $this->Wrapper->subscribe($topicArn, $listEndpointArns, $protocol);
        } else {
            $result = $this->Wrapper->subscribe($topicArn, $endpointArn, $protocol);
        }
        $this->out("Subscribe Topic $topicArn, Endpoint $endpointArn:");
        $this->out($result);
    }

    public function listSubscriptionsByTopic($topicArn = '')
    {
        $result = $this->Wrapper->listSubscriptionsByTopic($topicArn);
        $this->out("List Subscriber Topic $topicArn:");
        $this->out($result);
    }

    public function publishToTopic($topicArn = '', $message = '')
    {
        $result = $this->Wrapper->publishToTopic($topicArn, $message);
        $this->out("Publish message \"{$message}\" to $topicArn:");
        $this->out($result);
    }

    public function publishToEndpoint($endpointArn = '', $message = '')
    {
        $listEndpointArns = json_decode($endpointArn, true);
        if ($listEndpointArns) { // Multiple case
            $result = $this->Wrapper->publishToEndpoint($listEndpointArns, $message);
        } else {
            $result = $this->Wrapper->publishToEndpoint($endpointArn, $message);
        }
        $this->out("Publish message \"{$message}\" to $endpointArn:");
        $this->out($result);
    }

    public function createPlatformEndpoint($platform, $token)
    {
        $listTokens = json_decode($token, true);
        if ($listTokens) { // Multiple case
            $result = $this->Wrapper->createPlatformEndpoint($platform, $listTokens);
        } else {
            $result = $this->Wrapper->createPlatformEndpoint($platform, $token);
        }
        $this->out("Create Endpoint for token \"{$token}\":");
        $this->out($result);
    }

    public function getEndpointAttributes($endpointArn = '')
    {
        $result = $this->Wrapper->getEndpointAttributes($endpointArn);
        $this->out("Endpoint {$endpointArn} Attributes:");
        $this->out($result);
    }

    public function setEnabled($endpointArn = '')
    {
        $result = $this->Wrapper->setEnabled($endpointArn);
        $this->out("Create Endpoint {$endpointArn} Enabled:");
        $this->out($result);
    }

    public function out($message = NULL, $newlines = 1, $level = 1)
    {
        if (is_string($message)) {
            parent::out($message, $newlines, $level);
        } else {
            parent::out(pr($message), $newlines, $level);
        }
    }

    private function writeLog($message = '', $level = 'debug')
    {
        Log::write($level, $message, ['scope' => ['endpoint']]);
    }
}
