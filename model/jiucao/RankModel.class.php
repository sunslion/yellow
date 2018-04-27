<?php
defined('_VALID') or die('Restricted Access!');
class RankModel extends BaseModel
{
    protected $rank,$rank_range,$user_range,$user_rank_range;
    function __construct(){
        include BASE_PATH.'/include/config.rank.php';
        $this->rank = $rank;
        $this->rank_range = $rank_range;
        $this->user_range = $user_range;
        $this->user_rank_range = $user_rank_range;
    }
    public function getRange($sebi_surplus){
        foreach ($this->rank_range as $k => $v) {
            list($min,$max) = $v;
            if ($min <= $sebi_surplus && $max >= $sebi_surplus) {
                return  $k;
            }
        }
        return 0;
    }
    public function getPremium($range){
        foreach ($this->user_rank_range as $k => $v) {
            if (in_array($range, $v)) {
                return  $k;
            }
        }
        return 0;
    }
    public function getPreminumName($range) {
        if(isset($this->user_range[$range])){
            return $this->user_range[$range];
        }
        return '';
    }
}
?>