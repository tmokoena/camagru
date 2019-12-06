
(function () {
    var btn = document.getElementById('btn');
    var flbtn = document.getElementById('upload');
    var obj = document.getElementById('slider');
    var video = document.getElementById('video');
    var fbtn = document.createElement('input')

    var s = 0;
    var j = 1;
    const size = 400;

    navigator.getMedia =    navigator.getUserMedia ||
                            navigator.webkitGetUserMedia ||
                            navigator.mozGetUserMedia   ||
                            navigator.msGetUserMedia;
    navigator.getMedia({video:true}, handleVideo, errorHandle);

    function handleVideo(stream) {
        video .srcObject = stream;
    }
    function errorHandle(e) {
        alert("there was a problem connecting to webcam");
    }
    

    document.getElementById('btn').addEventListener("click", function () {
        var form = document.createElement('form');
        var video = document.getElementById('video');
        var sub = document.createElement('button');
        var text = document.createElement("INPUT");
        var stck = document.createElement("INPUT");
        var canvas  = document.createElement('canvas');
        var context = canvas.getContext('2d');
        
        canvas.width = 800;
        canvas.height = 600;
        context.drawImage(video,0,0,800,600);
        var newpic = canvas.toDataURL();
        text.setAttribute("name", "img")
        text.setAttribute("type", "text");
        text.setAttribute("value",newpic);
        stck.setAttribute("name", "stck")
        stck.setAttribute("type", "text");
        stck.setAttribute("value",document.getElementById('src').value);
        sub.type = "submit";
        sub.name ="sub";
        form.method = "POST";
        form.action = "cam.php";
        form.appendChild(text);
        form.appendChild(stck);
        form.appendChild(sub);
        document.body.appendChild(form);
        sub.click();
        form.reset();
        document.body.removeChild(form);
        // var img = document.createElement('img');
        // var div     = document.createElement('div');
        // var btt     = document.createElement('button');
        // var br = document.createElement('br');

        // btt.innerHTML = "Upload"+s;
        // btt.className = "bt";
        // div.className = "pht";
        // div.id = s;
        // img.src = $newpic;
        // div.appendChild(img);
        // div.appendChild(br);
        // div.appendChild(btt);
        // obj.appendChild(div);
        // canvas = NULL;
        // context =NULL;
        // s++;
    });

    var frm = document.createElement('form');
    var lup = document.createElement('button');
    var txtsec = document.createElement('input');
    
    fbtn.setAttribute('type','file');
    fbtn.setAttribute('name','file');
    txtsec.setAttribute('type','text');
    txtsec.setAttribute('name','txtsec');
    lup.setAttribute('type','submit');
    lup.setAttribute('name','lup');
    frm.method = "post";
    frm.action = 'cam.php';
    frm.enctype = 'multipart/form-data';
    frm.appendChild(txtsec);
    frm.appendChild(fbtn);
    frm.appendChild(lup);
    
    document.getElementById('upload').addEventListener('click',function(){
        txtsec.setAttribute('value',document.getElementById('src').value);
        fbtn.click();
    });
    
    fbtn.addEventListener('change',function(){
        document.body.appendChild(frm);
        lup.click();
        document.body.removeChild(frm);
    });

    document.getElementById('btf').addEventListener('click',function(){
        var src = document.getElementById('src');
        src.value = "";
        src.value = "stickers/btf.jpg";
        btn.disabled = false;
        flbtn.disabled = false;
    });
    document.getElementById('rex').addEventListener('click',function(){
        var src = document.getElementById('src');
        src.value = "";
        src.value = "stickers/rex.png";
        btn.disabled = false;
        flbtn.disabled = false;
    });
    document.getElementById('tt').addEventListener('click',function(){
        var src = document.getElementById('src');
        src.value = "";
        src.value = "stickers/tt.jpg";
        btn.disabled = false;
        flbtn.disabled = false;
    });
})();