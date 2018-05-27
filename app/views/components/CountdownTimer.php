<style>
/* body{
	text-align: center;
	background: #00ECB9;
  font-family: sans-serif;
  font-weight: 100;
} */

/* h1{
  color: #396;
  font-weight: 100;
  font-size: 40px;
  margin: 40px 0px 20px;
} */

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
