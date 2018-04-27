<?php
defined('_VALID') or die('Restricted Access!');
class Libs_Pagination
{
    private $page,$total,$pagesize,$page_total,$url;
    function __construct($total=0,$page=1,$pagesize=20){
        $this->page = $page <= 0 ? 1 : $page;
        $this->total = $total;
        $this->pagesize = $pagesize;
        $this->page_total = ceil($this->total / $this->pagesize);
    }
    public function getPagination($url='') {
        $this->url = $url;
        $block = array(
          'first' => null,
          'slider' => null,
          'last' => null
        );
        
        $side = 3;
        $window = $side * 2;
        if ($this->page_total < $window + 6) {
            $block['first'] = $this->getUrlRange(1, $this->page_total);
        }elseif ($this->page <= $window){
            $block['first'] = $this->getUrlRange(1, $window + 2);
            $block['last'] = $this->getUrlRange($this->page_total - 2, $this->page_total);
        }elseif ($this->page > ($this->page_total - $window)){
            $block['first'] = $this->getUrlRange(1, 2);
            $block['last'] = $this->getUrlRange($this->page_total - $window, $this->page_total);
        }else {
            $block['first'] = $this->getUrlRange(1,2);
            $block['slider'] = $this->getUrlRange($this->page, $this->page + $side);
            $block['last'] = $this->getUrlRange($this->page_total - 2, $this->page_total);
        }
        $html = '';
        $html .= $this->getPreviousButton('上一页');
        if (is_array($block['first'])) {
            $html .= $this->getUrlLinks($block['first']);
        }
        if (is_array($block['slider'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['slider']);
        }
        if (is_array($block['last'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['last']);
        }
        $html .= $this->getNextButton('下一页');
        return $html;
    }
    public function getUrlRange($start,$end){
        $urls = array();
        for ($i = $start; $i <= $end; $i++) {
            $urls[$i] = $this->url.'/p/'.$i;
        }
        return $urls;
    }
    /**
     * 上一页按钮
     * @param string $text
     * @return string
     */
    protected function getPreviousButton($text = "&laquo;")
    {
    
        if ($this->page <= 1) {
            return $this->getDisabledTextWrapper($text);
        }
    
        $url = $this->url.'/p/'.($this->page -1);
        return $this->getPageLinkWrapper($url, $text);
    }
    
    /**
     * 下一页按钮
     * @param string $text
     * @return string
     */
    protected function getNextButton($text = '&raquo;')
    {

        $url = $this->url.'/p/'.($this->page + 1);
    
        return $this->getPageLinkWrapper($url, $text);
    }
    /**
     * 生成一个可点击的按钮
     *
     * @param  string $url
     * @param  int    $page
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page)
    {
        return '<a href="' . htmlentities($url) . '">' . $page . '</a>';
    }
    
    /**
     * 生成一个禁用的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<span>' . $text . '</span>';
    }
    
    /**
     * 生成一个激活的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<span class="select">' . $text . '</span>';
    }
    
    /**
     * 生成省略号按钮
     *
     * @return string
     */
    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }
    
    /**
     * 批量生成页码按钮.
     *
     * @param  array $urls
     * @return string
     */
    protected function getUrlLinks(array $urls)
    {
        $html = '';
    
        foreach ($urls as $page => $url) {
            $html .= $this->getPageLinkWrapper($url, $page);
        }
    
        return $html;
    }
    
    /**
     * 生成普通页码按钮
     *
     * @param  string $url
     * @param  int    $page
     * @return string
     */
    protected function getPageLinkWrapper($url, $page)
    {
        if ($page == $this->page) {
            return $this->getActivePageWrapper($page);
        }
    
        return $this->getAvailablePageWrapper($url, $page);
    }
}
?>