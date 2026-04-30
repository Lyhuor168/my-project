<!DOCTYPE html>
<html lang="km">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Register — School System</title>
<link href="https://fonts.googleapis.com/css2?family=Spectral:wght@400;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;font-family:'Nunito',sans-serif;overflow:hidden}
body{background:#0d0f1a;}
.bg-mesh{position:fixed;inset:0;z-index:0;background:radial-gradient(ellipse 70% 60% at 80% 20%,rgba(99,43,200,.35) 0%,transparent 55%),radial-gradient(ellipse 60% 55% at 20% 80%,rgba(28,100,177,.25) 0%,transparent 55%),#0d0f1a;animation:meshMove 18s ease-in-out infinite alternate;}
@keyframes meshMove{0%{filter:hue-rotate(0deg)}100%{filter:hue-rotate(-20deg) brightness(.95)}}
#cvs{position:fixed;inset:0;z-index:1;pointer-events:none;}
.scene{position:relative;z-index:10;width:100%;height:100vh;display:flex;align-items:center;justify-content:center;padding:1.5rem;}
.card{display:grid;grid-template-columns:1fr 1fr;width:min(940px,100%);max-height:96vh;border-radius:24px;overflow:hidden;box-shadow:0 0 0 1px rgba(255,255,255,.07),0 40px 100px rgba(0,0,0,.6);animation:cardIn .55s cubic-bezier(.22,1,.36,1) both;}
@keyframes cardIn{from{opacity:0;transform:translateY(28px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
@media(max-width:640px){.card{grid-template-columns:1fr;}.deco{display:none;}}
.deco{position:relative;overflow:hidden;padding:3rem 2.5rem;display:flex;flex-direction:column;justify-content:space-between;background:linear-gradient(155deg,#5b21b6 0%,#3b0f8a 55%,#1e0654 100%);}
.deco::before{content:'';position:absolute;width:380px;height:380px;border-radius:50%;background:rgba(255,255,255,.05);bottom:-100px;right:-80px;}
.ring{position:absolute;border-radius:50%;border:1px solid rgba(255,255,255,.1);top:50%;left:50%;transform:translate(-50%,-50%);animation:rp 4s ease-in-out infinite;}
.ring1{width:280px;height:280px;}.ring2{width:430px;height:430px;border-color:rgba(255,255,255,.05);animation-delay:2s;}
@keyframes rp{0%,100%{transform:translate(-50%,-50%) scale(1)}50%{transform:translate(-50%,-50%) scale(1.05)}}
.di{position:relative;z-index:2;}
.logo{display:flex;align-items:center;gap:10px;font-family:'Spectral',serif;font-size:1.2rem;font-weight:700;color:#fff;}
.logo-box{width:40px;height:40px;border-radius:12px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;font-size:1.2rem;}
.dh{font-family:'Spectral',serif;font-size:2rem;font-weight:800;color:#fff;line-height:1.2;margin-bottom:.75rem;}
.dh em{font-style:normal;background:linear-gradient(90deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.ds{font-size:.85rem;color:rgba(255,255,255,.6);line-height:1.75;}
.pills{display:flex;flex-wrap:wrap;gap:8px;}
.pill{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);color:rgba(255,255,255,.8);font-size:.72rem;font-weight:600;padding:5px 13px;border-radius:20px;}
.login-note{font-size:.78rem;color:rgba(255,255,255,.5);margin-bottom:8px;}
.login-btn{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.25);color:#fff;font-family:'Nunito',sans-serif;font-size:.83rem;font-weight:700;padding:9px 20px;border-radius:50px;cursor:pointer;text-decoration:none;transition:background .18s;}
.login-btn:hover{background:rgba(255,255,255,.2);color:#fff;}
.fwrap{background:#12131f;display:flex;flex-direction:column;justify-content:center;padding:2.5rem;overflow-y:auto;max-height:96vh;scrollbar-width:none;}
.fwrap::-webkit-scrollbar{display:none;}
.fhead h2{font-family:'Spectral',serif;font-size:1.8rem;font-weight:800;color:#fff;margin-bottom:5px;}
.fhead h2 span{color:#a78bfa;}
.fhead p{font-size:.82rem;color:rgba(255,255,255,.35);margin-bottom:1.5rem;}
.alert-err{background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.25);color:#fca5a5;border-radius:10px;padding:10px 14px;font-size:.82rem;margin-bottom:1.2rem;display:flex;align-items:center;gap:8px;}
.field{display:flex;flex-direction:column;gap:5px;margin-bottom:.9rem;}
.field label{font-size:.68rem;font-weight:800;color:rgba(255,255,255,.35);letter-spacing:.1em;text-transform:uppercase;}
.iw{position:relative;}
.iw svg.ico{position:absolute;left:12px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:rgba(255,255,255,.22);pointer-events:none;transition:color .18s;}
.iw:focus-within svg.ico{color:#a78bfa;}
.iw input{width:100%;padding:11px 12px 11px 36px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);border-radius:10px;color:#fff;font-family:'Nunito',sans-serif;font-size:.875rem;transition:border-color .18s,box-shadow .18s;}
.iw input::placeholder{color:rgba(255,255,255,.18);}
.iw input:focus{outline:none;border-color:#a78bfa;box-shadow:0 0 0 3px rgba(167,139,250,.12);}
.iw input.is-invalid{border-color:#f87171;}
.tog-pw{position:absolute;right:11px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.25);cursor:pointer;display:flex;}
.iw:has(.tog-pw) input{padding-right:36px;}
.field-err{font-size:.7rem;color:#f87171;margin-top:2px;}
.str-wrap{margin-top:4px;}
.str-bar{height:3px;border-radius:3px;background:rgba(255,255,255,.08);overflow:hidden;}
.str-fill{height:100%;border-radius:3px;width:0;transition:width .3s,background .3s;}
.str-lbl{font-size:.68rem;color:rgba(255,255,255,.28);margin-top:3px;}
.btn-reg{width:100%;padding:13px;background:linear-gradient(135deg,#7c3aed,#a78bfa);color:#fff;border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-size:.9rem;font-weight:800;cursor:pointer;letter-spacing:.04em;box-shadow:0 6px 24px rgba(167,139,250,.28);transition:opacity .15s,transform .1s;margin-top:.4rem;}
.btn-reg:hover{opacity:.92;transform:translateY(-1px);}
</style>
</head>
<body>
<div class="bg-mesh"></div>
<canvas id="cvs"></canvas>

<div class="scene">
<div class="card">

    {{-- DECO --}}
    <div class="deco">
        <div class="ring ring1"></div>
        <div class="ring ring2"></div>
        <div class="di">
            <div class="logo"><div class="logo-box">🎓</div> School System</div>
        </div>
        <div class="di">
            <div class="dh">Join<br><em>Today!</em></div>
            <p class="ds">Create your free account and unlock access to all campus resources in minutes.</p>
        </div>
        <div class="di">
            <div class="pills">
                <span class="pill">🚀 Free</span>
                <span class="pill">✅ Instant Access</span>
                <span class="pill">🔒 Secure</span>
            </div>
            <div style="margin-top:1.25rem;">
                <p class="login-note">Already a member?</p>
                <a href="{{ route('login') }}" class="login-btn">Sign in instead →</a>
            </div>
        </div>
    </div>

    {{-- REGISTER FORM --}}
    <div class="fwrap">
        <div class="fhead">
            <h2>Create <span>Account</span></h2>
            <p>Join thousands of students</p>
        </div>

        @if($errors->any())
        <div class="alert-err">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        {{-- ✅ FORM ជាមួយ @csrf + route('register') --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name --}}
            <div class="field">
                <label>ឈ្មោះ / Full Name *</label>
                <div class="iw">
                    <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input type="text" name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g. លី ហួ"
                        class="{{ $errors->has('name') ? 'is-invalid':'' }}"
                        autocomplete="name" autofocus/>
                </div>
                @error('name') <div class="field-err">{{ $message }}</div> @enderror
            </div>

            {{-- Email --}}
            <div class="field">
                <label>Email address *</label>
                <div class="iw">
                    <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <input type="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="you@school.edu"
                        class="{{ $errors->has('email') ? 'is-invalid':'' }}"
                        autocomplete="email"/>
                </div>
                @error('email') <div class="field-err">{{ $message }}</div> @enderror
            </div>

            {{-- Password --}}
            <div class="field">
                <label>Password *</label>
                <div class="iw">
                    <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" name="password"
                        placeholder="Min. 8 characters"
                        class="{{ $errors->has('password') ? 'is-invalid':'' }}"
                        autocomplete="new-password"
                        oninput="chkStr(this.value)"/>
                    <button type="button" class="tog-pw" onclick="togPw(this)">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                <div class="str-wrap" id="sw" style="display:none;">
                    <div class="str-bar"><div class="str-fill" id="sf"></div></div>
                    <div class="str-lbl" id="sl"></div>
                </div>
                @error('password') <div class="field-err">{{ $message }}</div> @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="field">
                <label>Confirm Password *</label>
                <div class="iw">
                    <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" name="password_confirmation"
                        placeholder="Repeat password"
                        autocomplete="new-password"/>
                </div>
            </div>

            {{-- ✅ Submit --}}
            <button type="submit" class="btn-reg">Create Account →</button>

            <p style="text-align:center;font-size:.78rem;color:rgba(255,255,255,.22);margin-top:1rem;">
                Already have an account?
                <a href="{{ route('login') }}" style="color:#a78bfa;text-decoration:none;font-weight:700;">Sign in →</a>
            </p>

        </form>
    </div>

</div>
</div>

<script>
const cvs=document.getElementById('cvs'),ctx=cvs.getContext('2d');let W,H,dots=[];
function resize(){W=cvs.width=innerWidth;H=cvs.height=innerHeight;}
function mkD(){dots=Array.from({length:Math.max(30,Math.floor(W*H/16000))},()=>({x:Math.random()*W,y:Math.random()*H,r:Math.random()*1.3+.3,vx:(Math.random()-.5)*.2,vy:(Math.random()-.5)*.2,a:Math.random()*.4+.1,c:['167,139,250','124,92,252','99,102,241'][Math.floor(Math.random()*3)]}));}
function loop(){ctx.clearRect(0,0,W,H);for(let i=0;i<dots.length;i++)for(let j=i+1;j<dots.length;j++){const dx=dots[i].x-dots[j].x,dy=dots[i].y-dots[j].y,d=Math.hypot(dx,dy);if(d<110){ctx.beginPath();ctx.strokeStyle=`rgba(150,100,255,${(1-d/110)*.08})`;ctx.lineWidth=.5;ctx.moveTo(dots[i].x,dots[i].y);ctx.lineTo(dots[j].x,dots[j].y);ctx.stroke();}}
dots.forEach(d=>{ctx.beginPath();ctx.arc(d.x,d.y,d.r,0,Math.PI*2);ctx.fillStyle=`rgba(${d.c},${d.a*.8})`;ctx.fill();d.x+=d.vx;d.y+=d.vy;if(d.x<0||d.x>W)d.vx*=-1;if(d.y<0||d.y>H)d.vy*=-1;});requestAnimationFrame(loop);}
window.addEventListener('resize',()=>{resize();mkD();});resize();mkD();loop();
function togPw(btn){const inp=btn.previousElementSibling;inp.type=inp.type==='text'?'password':'text';}
function chkStr(v){const w=document.getElementById('sw'),f=document.getElementById('sf'),l=document.getElementById('sl');if(!v){w.style.display='none';return;}w.style.display='block';let s=0;if(v.length>=8)s++;if(v.length>=12)s++;if(/[A-Z]/.test(v))s++;if(/[0-9]/.test(v))s++;if(/[^A-Za-z0-9]/.test(v))s++;const lv=[{w:'16%',bg:'#f87171',t:'Very weak'},{w:'32%',bg:'#fb923c',t:'Weak'},{w:'55%',bg:'#fbbf24',t:'Fair'},{w:'78%',bg:'#34d399',t:'Strong'},{w:'100%',bg:'#22d3ee',t:'Very strong'}][Math.min(s,4)];f.style.width=lv.w;f.style.background=lv.bg;l.textContent=lv.t;l.style.color=lv.bg;}
</script>
</body>
</html>