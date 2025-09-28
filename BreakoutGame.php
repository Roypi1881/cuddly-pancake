<?php
// Simple PHP+HTML5 Canvas Breakout Game. Save as BreakoutGame.php and open in browser with PHP server.
?>
<!DOCTYPE html>
<html>
<head>
<title>Breakout Game</title>
<style>
body { background: #111; color: #fff; font-family: Arial;}
canvas { background: #222; display: block; margin: 40px auto; border-radius:10px;}
</style>
</head>
<body>
<h1 style="text-align:center;">Breakout Game</h1>
<canvas id="game" width="600" height="400"></canvas>
<script>
const canvas = document.getElementById("game"), ctx = canvas.getContext("2d");
let paddle = { x: 260, w: 80, h: 14 }, ball = { x: 300, y: 250, vx: 4, vy: -4, r: 10 };
let bricks = [], rows = 5, cols = 8, brickw = 68, brickh = 22;
for(let r=0;r<rows;r++)for(let c=0;c<cols;c++)bricks.push({x:20+c*74,y:40+r*28,alive:true});
document.addEventListener("mousemove", e=>{
  let rect = canvas.getBoundingClientRect();
  paddle.x = e.clientX - rect.left - paddle.w/2;
});
function collide(b, o) {
  return b.x+b.r>o.x&&b.x-b.r<o.x+o.w&&b.y+b.r>o.y&&b.y-b.r<o.y+o.h;
}
function draw() {
  ctx.clearRect(0,0,600,400);
  ctx.fillStyle="#0f0"; ctx.fillRect(paddle.x,380,paddle.w,paddle.h);
  ctx.beginPath(); ctx.arc(ball.x,ball.y,ball.r,0,2*Math.PI); ctx.fillStyle="#ff0"; ctx.fill();
  bricks.forEach(br=>{
    if(br.alive){ ctx.fillStyle="#f44"; ctx.fillRect(br.x,br.y,brickw,brickh);}
  });
}
function update() {
  ball.x+=ball.vx; ball.y+=ball.vy;
  if(ball.x-ball.r<0||ball.x+ball.r>600)ball.vx*=-1;
  if(ball.y-ball.r<0)ball.vy*=-1;
  if(ball.y+ball.r>400) { ball.x=300; ball.y=250; ball.vx=4; ball.vy=-4;}
  if(collide(ball,{x:paddle.x,y:380,w:paddle.w,h:paddle.h}))ball.vy=-Math.abs(ball.vy);
  bricks.forEach(br=>{
    if(br.alive&&collide(ball,{x:br.x,y:br.y,w:brickw,h:brickh})){
      br.alive=false; ball.vy*=-1;
    }
  });
}
setInterval(()=>{ update(); draw(); }, 1000/60);
</script>
</body>
</html>