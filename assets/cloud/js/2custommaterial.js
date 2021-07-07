/*Rococpy Cloud Custom Materal JS V1.0.0
Copyright 2019 - 2021 Rococpy All rights reserved.*/

function showPopup(idx) { window.open(`https://cloud.rococpy.com/view/img/${idx}`, "Image", "width=100"); }
function formatBytes(bytes, decimals = 2) {
  if (bytes === 0) return '0 Bytes';

  const k = 1024;
  const dm = decimals < 0 ? 0 : decimals;
  const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

  const i = Math.floor(Math.log(bytes) / Math.log(k));

  return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function progress(idx, percentage, now, total) {
  $(`.uploadidx_${idx} .bars`).css({width:percentage+'%'}, 300);
  $(`.uploadidx_${idx} .per`).text(`${percentage.toFixed(2)}%`);
  $(`.uploadidx_${idx} .nowupload`).text(`${formatBytes(now)}`);
  $(`.uploadidx_${idx} .totaluplaod`).text(`${formatBytes(total)}`);
  if (percentage >= 100) {
    $(`.uploadidx_${idx} .size`).text(`Upload Complete`);
    $(`.uploadidx_${idx} .per`).text(`100%`);
    $(`.uploadidx_${idx} .uploadico`).html('done')
    $(`.uploadidx_${idx} p`).text(`파일 업로드 완료`);
    setTimeout(() => {
      $(`.uploadidx_${idx}`).animate({
        height: 0},
        500, () => {
          $(`.uploadidx_${idx}`).remove();
      });
    }, 3000)
  }
}

function blobmedia(type){
  const src = $(`#main .load_${type}`).val();
  $(`#main .load_${type}`).remove();
  if (src) Convater.media(type, src)
}

let shareck = "";
let cont = 0;
let upload = [];

const Start = {
  modal:"",
  init(){
    this.hook();

    $(".loading").css({
      "visibility": "hidden",
      "opacity": 0
    })

    window.onpopstate = (e) => {
      e.preventDefault();

      locate.rebload(100)
    }

    $("#main > .container > div:not(:first-child)").hide()

    if($("video")[0]) blobmedia("video");
    if($("audio")[0]) blobmedia("audio");
    if($("img")[0]) blobmedia("img");

    Ajax.init();
  },
  hook(){
    $(document)
      .on("keydown", (e) => {

        if(e.keyCode == 116){
          e.preventDefault()
          $("#main").html('')

          locate.fullreload();
        }
      })

      .on("click", ".sidenav-trigger", function(e) {
        e.preventDefault()

        Start.side = $(this).data("target");
        
        $(".sidenav-overlay").css("display", "block");

        setTimeout(() => {
          $(`#${Start.side}`).css("transform", "translateX(0%)");
          $(`body`).css("overflow", "hidden");
          $(".sidenav-overlay").css("opacity", "1");
        }, 10);
      })

      .on("click", ".sidenav-overlay", function(e) {
        e.preventDefault()

        $(`#${Start.side}`).css("transform", "translateX(-105%)");
        $(`body`).css("overflow", "auto");
        $(".sidenav-overlay").css("opacity", "0");

        setTimeout(() => {
          $(".sidenav-overlay").css("display", "none");
        }, 350);
      })

      .on("click", ".tabs .tab a", function(e) {
        e.preventDefault()

        const target = $(this).attr("href");
        
        $("#main > .container > div").hide().removeClass("active");
        $(`${target}`).css("display", "block").addClass("active");
      })
      
      .on("click", ".modal-trigger", function(e) {
        const target = $(this).attr("href");

        if(/^(#.+)$/.exec(target)) e.preventDefault()
        
        Start.modal = target;

        $(target).parent().append(`<div class="modal-overlay"></div>`)
        $(target).show().addClass("show");
        $(".modal-overlay").show();

        setTimeout(() => {
          $(target).css({
            "z-index": "1003",
            "opacity": "1",
            "top": "10%",
            "transform":"scale(1)"
          });

          $(".modal-overlay").css({
            "z-index": "1002",
            "opacity": "0.5",
          });
        }, 10);
      })

      .on("click", ".modal-overlay", function(e) {
        e.preventDefault();

        $(`${Start.modal}`).css({
          "z-index": "1003",
          "opacity": "0",
          "top": "4%",
          "transform":"scale(0.8)"
        }).removeClass("show");

        $(".modal-overlay").css({
          "opacity": "0"
        });

        setTimeout(() => {
          $(`${Start.modal}`).hide();
          $(".modal-overlay").remove();
        }, 350);
      })

      .on("input", "#files", function() {
        const target = $(this)[0].files;

        if(target.length == 1) $(".file-path-wrapper > .file-path").val(target[0].name)
        else if(target.length > 1) $(".file-path-wrapper > .file-path").val(`${target[0].name} 외 ${target.length - 1}개`)
        else $(".file-path-wrapper > .file-path").val(``)
      })
      
      .on("focus", "input", function() {
        const target = $(this).attr("id");

        $(`label[for=${target}]`).addClass("active");
      })

      .on("blur", "input", function() {
        if($(this).val() == "") $("label").removeClass("active");
      })

      .on("click", ".dnt_mv_t_mv", function(e) {
        e.preventDefault();

        const target = $(this).attr("href");

        locate.load(target)
      })

      .on("click", ".backaction", function(e){
        e.preventDefault();

        const type = $(this).data("type");
        const target = $(this).attr("href");

        switch (type) {
          case "Abandon":
            locate.start();
            $.get(target, (data) => {
              
              alert(data);

              locate.load("/");
            })
            break;
          default:
            // statements_def
            break;
        }
      })

      .on("click", ".upload_cancel", function(){
        data = $(this).data('idx');
        upload[data].abort();
        $(`.uploadidx_${data} .size, .uploadidx_${data} .per`).text(`Canceled`);
        $(`.uploadidx_${data} p`).text(`파일 업로드 취소`);
        setTimeout(() => {
          $(`.uploadidx_${data}`).animate({
            height: 0},
            500, () => {
              $(`.uploadidx_${data}`).remove();
          });
        }, 3000)
      })

      .on("submit", "#form", function(e) {
        e.preventDefault(); 
      
        const ccont = cont;
        let upfiles_cnt = $("input:file")[0].files.length;
        let formData = new FormData($('#form')[0]);
      
        $(this).each(function() {  
            this.reset();  
        }); 
      
        let oldXHR = $.ajaxSettings.xhr;
        $.ajaxSettings.xhr = function() {
          let xhr = oldXHR.apply(this, arguments);

          if(xhr instanceof window.XMLHttpRequest) xhr.addEventListener('progress', this.progress, false);
          if(xhr.upload) xhr.upload.addEventListener('progress', this.progress, false);

          return xhr;
        };
      
        $('.ctoast').append(`<div class="uploading uploadidx_${ccont}">
          <div class="uploadingtop">
            <i class="material-icons uploadico">cloud<i class="material-icons absolute-ico">cached</i></i>
            <p>파일 ${upfiles_cnt}개 업로드 중</p>
            <i class="material-icons upload_cancel" data-idx="${ccont}">cancel</i>
          </div>
          <div class="uploadingbtn">
            <div class="progressbar">
              <div class="bars"></div>
              <div class="per">0%</div>
              <div class="size"><b class="nowupload"></b> / <b class="totaluplaod"></b></div>
            </div>
          </div>
        </div>`)
      
        upload[ccont] = $.ajax({
          url : '/upload',
          type: 'POST',
          data: formData,
          cache: false,
          processData:false,
          contentType: false,
          progress: function(e) {
            percentage = e.loaded / e.total * 100;
            progress(ccont, percentage, e.loaded, e.total);
          },
      
          success: () => locate.rebload(),
          error: (err) => dd('error: ',err.statusText)
        });
      
        cont++;
      })

      .on("submit", "#Abandon, #downloada, #delete, #restone", function(e) {
        e.preventDefault(); 

        let vals = [];
        let url = $(this).attr("action");
        let type = $(this).attr("method");
        let checkbox = $(this).find("input:checked");

        $.each(checkbox, (key, val) => vals.push($(val).val()))

        if (url == "/download") {return location.href = `/download/${vals[0]}`}

        $.post(url, {idxs: JSON.stringify(vals)}, function(data, textStatus, xhr) {
          alert(data);

          locate.rebload()
        });
      })
  }
}

const locate = {
  start(){
    $(".loading").css({
      "visibility": "visible",
      "opacity": 1
    })
  },

  end(){
    $(".loading").css({
      "visibility": "hidden",
      "opacity": 0
    })
  },

  rebload(time = ""){
    locate.start();
    const target = location.href;
    if (time == "") time = 100

    setTimeout(() => {
      $("#main").load(`${target} #main`, (response, status, xhr) => {
        if(status == "error") return alert(xhr.status == 0 ? "알 수 없는 오류가 발생하였습니다.\n리로드 후에도 정상적으로 작동하지않는다면 CTRL + R을 눌러주세요. " : `Code ${xhr.status}가 반환되었습니다.`);

        $("#main").html($("#main").html().replace(`<section id="main">`, "").replace(`</section>`, ""))

        $("#main > .container > div:not(:first-child)").hide()

        if($("video")[0]) blobmedia("video");
        if($("audio")[0]) blobmedia("audio");
        if($("img")[0]) blobmedia("img");

        locate.end();
      });
    }, time)
  },

  fullreload(){
    locate.start();
    const target = location.href;

    setTimeout(() => {

      $.ajax({
        url : `${target}`,
        success : function(result) {
          const ctnhtml = $("<html>");
          $(ctnhtml).html(result)
          $(ctnhtml).children('meta, link, title, script').remove()

          $("#bodyload").html($(ctnhtml).html());

          $("#main > .container > div:not(:first-child)").hide()

          if($("video")[0]) blobmedia("video");
          if($("audio")[0]) blobmedia("audio");
          if($("img")[0]) blobmedia("img");

          locate.end();
        }
      });
      
    }, 500)
  },

  load(url){
    locate.start();
    const target = url;
      
    setTimeout(() => {
      $("#main").load(`${target} #main`, (response, status, xhr) => {
        if(status == "error") return alert(xhr.status == 0 ? "알 수 없는 오류가 발생하였습니다.\n리로드 후에도 정상적으로 작동하지않는다면 CTRL + R을 눌러주세요. " :  `Code ${xhr.status}가 반환되었습니다.`);

        history.pushState("", "", target)
        $("#main").html($("#main").html().replace(`<section id="main">`, "").replace(`</section>`, ""))
        
        $("#main > .container > div:not(:first-child)").hide()
        
        if($("video")[0]) blobmedia("video");
        if($("audio")[0]) blobmedia("audio");
        if($("img")[0]) blobmedia("img");
        

        locate.end();
      });
    }, 100)
  }
}

const Convater = {
  async media(type, url){
    blob = await fetch(url).then(r => r.blob())

    $(`#main ${type}`)[0].src = URL.createObjectURL(blob);
    $(`#main ${type}`).attr("poster", "");
  }
}

const edit = {
  save(idx, msg){
    $("#share").is(":checked") ? shareck = "1" : shareck = "0";
    $.ajax({
      url: `/edit/${idx}`,
      type: 'POST',
      data: {
        filename: $("#filename").val(),
        check: $("#check").val(),
        share: shareck,
        life: $("#life").val(),
        note: $("#note").val()
      }
    })
    .done(() => {
      alert(msg);
      locate.rebload();
    })
  }
}

const Ajax = {
  init(){
    $(document)
      .on("click", ".kor", function(){
        $.ajax({
          url: '/language',
          type: 'POST',
          data: {data: 'ko'},
        })
        .done(function() {
          alert("변경되었습니다.");
          locate.rebload();
        })
      })
      .on("click", ".eng", function(){
        $.ajax({
          url: '/language',
          type: 'POST',
          data: {data: 'en'},
        })
        .done(function() {
          alert("Language Changed Successfully");
          alert("The selected language has a wrong translation using the translator!");
          locate.rebload();
        })
      })
      .on("click", ".ja", function(){
        $.ajax({
          url: '/language',
          type: 'POST',
          data: {data: 'ja'},
        })
        .done(function() {
          alert("言語が正常に変更されました");
          alert("選択した言語は、翻訳を使用して誤った翻訳があります！");
          locate.rebload();
        })
      })
      .on("click", ".changecolor", function(){
        $.ajax({
          url: '/switch_dark',
          type: 'POST'
        })
        .done((data) => {
          $(".changecolor > i").text($(".changecolor > i").text() == "brightness_4" ? "brightness_7" : "brightness_4")
          data.trim() == "lightmode" ? $("#dark_csses").remove() : $("body").prepend(`<link rel="stylesheet" id="dark_csses" type="text/css" href="/assets/cloud/css/dark.css">`);
        })
      })

  }
}







$(() => {
  Start.init()
})