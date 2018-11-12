<style>
#clockdiv{
	font-family: sans-serif;
	color: #fff;
	display: inline-block;
	font-weight: 100;
	text-align: center;
	font-size: 30px;
}

#clockdiv > div{
	padding: 10px;
	border-radius: 3px;
	background: #02255a;
	display: inline-block;
}

#clockdiv div > span{
	padding: 15px;
	border-radius: 3px;
	background: #011028;
	display: inline-block;
}

.smalltext{
	padding-top: 5px;
	font-size: 16px;
}
</style>
<div id="clockdiv">
  <div>
    <span class="days"></span>
    <div class="smalltext">Days</div>
  </div>
  <div>
    <span class="hours"></span>
    <div class="smalltext">Hours</div>
  </div>
  <div>
    <span class="minutes"></span>
    <div class="smalltext">Minutes</div>
  </div>
  <div>
    <span class="seconds"></span>
    <div class="smalltext">Seconds</div>
  </div>
</div>
