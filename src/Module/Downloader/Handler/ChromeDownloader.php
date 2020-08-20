<?php
namespace Yurun\Crawler\Module\Downloader\Handler;

use Yurun\Util\HttpRequest;
use HeadlessChromium\Browser;
use Imi\Bean\Annotation\Bean;
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Cookies\Cookie;
use Psr\Http\Message\ResponseInterface;
use Yurun\Util\YurunHttp\Http\Response;
use Yurun\Crawler\Module\Proxy\Model\Proxy;
use Psr\Http\Message\ServerRequestInterface;
use HeadlessChromium\Communication\Connection;
use Yurun\Crawler\Module\Proxy\Enum\ProxyType;
use Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem;
use Yurun\Crawler\Module\Downloader\Contract\BaseDownloader;
use Yurun\Crawler\Module\Downloader\Annotation\ChromeNavigation;

/**
 * 基于 Chrome headless 的下载器
 * 
 * @Bean("ChromeDownloader")
 */
class ChromeDownloader extends BaseDownloader
{
    /**
     * 可执行文件路径或http接口地址
     *
     * @var string
     */
    protected $path;

    /**
     * 创建浏览器的参数
     *
     * @var array
     */
    protected $options;

    /**
     * 下载内容
     *
     * @param \Yurun\Crawler\Module\Crawler\Contract\ICrawlerItem $crawlerItem
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Yurun\Crawler\Module\Proxy\Model\Proxy $proxy
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function download(ICrawlerItem $crawlerItem, ServerRequestInterface $request, ?Proxy $proxy = null): ResponseInterface
    {
        $browser = $this->createBrowser($needClose);
        try {
            $page = $browser->createPage();
            // cookies
            $cookies = [];
            foreach($request->getCookieParams() as $k => $v)
            {
                $cookies[] = Cookie::create($k, $v);
            }
            $page->setCookies($cookies);
            // navigate
            /** @var ChromeNavigation $chromeNavigation */
            $chromeNavigation = $crawlerItem->autoGetAnnotation(ChromeNavigation::class);
            if(!$chromeNavigation)
            {
                $chromeNavigation = new ChromeNavigation;
            }
            $page->navigate($request->getUri()->__toString())->waitForNavigation($chromeNavigation->eventName, $chromeNavigation->timeout);
            // body
            $body = $page->evaluate('document.documentElement.outerHTML')->getReturnValue();
            $response = new Response($body);
            // cookie
            $cookieStr = $page->evaluate('document.cookie')->getReturnValue();
            if($cookieStr)
            {
                $cookieOriginParams = [];
                foreach(explode(';', $cookieStr) as $item)
                {
                    [$name, $value] = explode('=', $item, 2);
                    $cookieOriginParams[trim($name)] = [
                        'value' =>  $value,
                    ];
                }
                $response = $response->withCookieOriginParams($cookieOriginParams);
            }
            return $response;
        } finally {
            if(isset($page))
            {
                $page->close();
            }
            if($needClose)
            {
                $browser->close();
            }
        }
    }

    /**
     * 创建浏览器对象
     *
     * @param boolean|null $needClose
     * @param \Yurun\Crawler\Module\Proxy\Model\Proxy|null $proxy
     * @return \HeadlessChromium\Browser
     */
    public function createBrowser(?bool &$needClose, ?Proxy $proxy = null): Browser
    {
        if('http://' === substr($this->path, 0, 7))
        {
            $http = new HttpRequest;
            $data = $http->get($this->path)->json(true);
            if(!isset($data[0]['webSocketDebuggerUrl']))
            {
                throw new \RuntimeException('Not found webSocketDebuggerUrl');
            }
            $connection = new Connection($data[0]['webSocketDebuggerUrl']);
            if(!$connection->connect())
            {
                throw new \RuntimeException('Connect to chrome failed');
            }
            $needClose = false;
            return $this->browser = new Browser($connection);
        }
        else
        {
            $factory = new BrowserFactory($this->path);
            $needClose = true;
            $options = $this->options;
            if($proxy)
            {
                switch($proxy->type)
                {
                    case ProxyType::HTTP:
                        $options['customFlags'][] = '--proxy-server=http=' . $proxy->host . ':' . $proxy->port;
                        break;
                    case ProxyType::SOCKS5:
                        $options['customFlags'][] = '--proxy-server="socks5://' . $proxy->host . ':' . $proxy->port . '"';
                        break;
                }
            }
            return $this->browser = $factory->createBrowser($options);
        }
    }

    /**
     * Get 可执行文件路径或http接口地址
     *
     * @return string
     */ 
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set 可执行文件路径或http接口地址
     *
     * @param string $path  可执行文件路径或http接口地址
     *
     * @return self
     */ 
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get 创建浏览器的参数
     *
     * @return array
     */ 
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set 创建浏览器的参数
     *
     * @param array $options  创建浏览器的参数
     *
     * @return self
     */ 
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

}
