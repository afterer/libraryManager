<?php
/*
 * 这是自习室的座位表，记录各个自习室的各个座位的选座情况
 */

namespace app\index\model;
use think\Model;

class Seat extends Model{
    //表示seat_seat_number数据表
	protected $tableName="seat_seat";
}
?>