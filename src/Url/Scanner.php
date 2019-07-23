<?php
/**
 * Just for learning not commerical
 *
 * @author    Joe.Chan<cshujun21625@gmail.com>
 * @date      2019年7月23日 下午4:03:18
 * @link      git@github.com:yuanmingtao/l1.git
 */
namespace yuanmingtao\ModernPHP\Url;
class Scanner
{
    /**
     * @var array An array of URLs
     */
    protected $urls;
    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;
    /**
     * Constructor
     * @param array $urls An array of URLs to scan
     */
    public function __construct(array $urls)
    {
        $this->urls = $urls;
    }
    /**
     * Get invalid URLs
     * @return array
     */
    public function getInvalidUrls()
    {
        $invalidUrls = [];
        foreach($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
            } catch (\Exception $e) {
                $statusCode = 500;
            }
            
            if ($statusCode >= 400) {
                array_push($invalidUrls, [
                    'url' => $url,
                    'status' => $statusCode
                ]);
            }
        }
        
        return $invalidUrls;
    }
    
    /**
     * Get HTTP status code for URL
     * @param string $url The remote URL
     * @return int The HTTP status code
     */
    protected function getStatusCodeForUrl($url)
    {
        $httpResponse = $this->httpClient->options($url);
        return $httpResponse->getStatusCode();
    }
}