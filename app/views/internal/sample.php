<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title> マイページ </title>
</head>
	<?php //echo Asset::js('dhtmlxscheduler.js'); ?>
	<?php echo Asset::js('http://localhost/assets/js/dhtmlxscheduler.js'); ?>
	<?php echo Asset::js('http://localhost/assets/js/dhtmlxscheduler_units.js'); ?>
    <?php echo Asset::css('http://localhost/assets/css/dhtmlxscheduler_material.css'); ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!-- <script src="../../codebase/dhtmlxscheduler.js?v=5.3.9" type="text/javascript" charset="utf-8"></script>
	<script src="../../codebase/ext/dhtmlxscheduler_units.js?v=5.3.9" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="../../codebase/dhtmlxscheduler_material.css?v=5.3.9" type="text/css" charset="utf-8"> -->
	
<style type="text/css" >
	html, body{
		margin:0px;
		padding:0px;
		height:100%;
		overflow:hidden;
	}	
</style>


<script type="text/javascript" charset="utf-8">
	const button = document.getElementsByClassName("dhx_save_btn_set");

	function init() {
		var sections = [];

		// 初期値の取得
		$.ajax({
			// action_init に通信
			url: '/fuelphp/public/internal/mypage/init',
			type: 'POST',
			dataType: 'json',
		})

		// 引数はaction_init からかえってきたもの
		.done(function(init_data) {
			// 通信成功時の処理を記述
			console.log("TRUE");
			var tmp_sections=[];
			
			init_data.forEach(function(value)
			{
				tmp_sections = { key:value['area_id'], label:value['full_name'] };
				sections.push(tmp_sections)
			});

			scheduler.createUnitsView({
				name:"unit",
				property:"section_id",
				list:sections
			});
			scheduler.config.multi_day = true;
			scheduler.init('scheduler_here',new Date(),"unit");
		})

		.fail(function() {
			// 通信失敗時の処理を記述
			console.log("FALSE");
			return null;
		});
		// scheduler.load(data);

		scheduler.locale.labels.unit_tab = "Unit"
		scheduler.locale.labels.section_custom="Section";
		scheduler.config.details_on_create=true;
		scheduler.config.details_on_dblclick=true;
		
		scheduler.config.lightbox.sections=[	
			{name:"description", height:130, map_to:"text", type:"textarea" , focus:true},
			{name:"custom", height:23, type:"select", options:sections, map_to:"section_id" },
			{name:"time", height:72, type:"time", map_to:"auto"}
		]

		// var data = load_schedule();
		$.ajax({
			url: '/fuelphp/public/internal/mypage/loadschedule',
			type: 'POST',
			dataType: 'json',
			data:{
				'user_id':8,//TODO::user_idを取得
			} 
		})
		.done(function(ev) {
			// 通信成功時の処理を記述
			console.log("seikou2");
			console.log(ev);
			// scheduler.load(JSON.parse(ev));
		})
		.fail(function() {
			// 通信失敗時の処理を記述
			console.log("sippai2");
			return null;
		});
	}
    
    $(function () {
		scheduler.attachEvent("onEventSave",function(id,ev,is_new){
			var result = save_event(id, ev, is_new ,'insert_or_update');
			return result;
		});

		scheduler.attachEvent("onSchedulerResize", function(ev){
			// var result = save_event(ev);
			// console.log(result);
			return true;
		});

		scheduler.attachEvent("onEventDragIn", function (ev){
			var result = save_event(ev);
			return result;
		});	
		
		var dragged_event;
		scheduler.attachEvent("onBeforeDrag", function (id, mode, e){
			// use it to get the object of the dragged event
			dragged_event = scheduler.getEvent(id); 
			// console.log(dragged_event);
			return true;
		});

		scheduler.attachEvent("onDragEnd", function(id, mode, e){
			if(typeof dragged_event !== "undefined"){
				var event_obj = dragged_event;
				var id = id;
				var ev = event_obj;
				var is_new = '';
				var result = save_event(id, ev, is_new,'update');
				return result;
			}
		});

		scheduler.attachEvent("onEventDeleted", function(id, ev){
			var result = save_event(id, ev, '', 'delete');
		});
	});

	function save_event(id,ev,is_new,type){
		if (!ev.text) {
			alert("Text must not be empty");
			return false;
		}

		$.ajax({
			url: '/fuelphp/public/internal/mypage/save',
			type: 'POST',
			dataType: 'json',
			data:{
				'event_id'	 : id,
				'event_info' : ev,
				'is_new'	 : is_new,
				'type'		 : type,
			} 
		})
		.done(function(ev) {
			// 通信成功時の処理を記述
			console.log("seikou");
			if(ev !== 0){
				scheduler.changeEventId(id, ev);
			}
		})
		.fail(function() {
			// 通信失敗時の処理を記述
			console.log("sippai");
		});
		return true;
	}

	function load_schedule(){

		$.ajax({
			url: '/fuelphp/public/internal/mypage/loadschedule',
			type: 'POST',
			dataType: 'json',
			data:{
				'user_id':8,//TODO::user_idを取得
			} 
		})
		.done(function(ev) {
			// 通信成功時の処理を記述
			console.log("seikou2");
			return ev;
		})
		.fail(function() {
			// 通信失敗時の処理を記述
			console.log("sippai2");
			return null;
		});
	}
</script>

<body onload="init();">
	<h1> マイページへようこそ </h1><hr>
	<!-- console.log( ); -->
	<?php var_dump($_POST); ?>
    <h2> 予約状況 </h2>
    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
        <div class="dhx_cal_navline">
            <div class="dhx_cal_prev_button">&nbsp;</div>
            <div class="dhx_cal_next_button">&nbsp;</div>
            <div class="dhx_cal_today_button"></div>
            <div class="dhx_cal_date"></div>
            <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
            <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
            <div class="dhx_cal_tab" name="unit_tab" style="right:280px;"></div>
            <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
		</div>
		
        <div class="dhx_cal_header">
		</div>
		
        <div class="dhx_cal_data">
        </div>		
    </div>
</body>
</html>