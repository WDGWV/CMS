var currentModal = ''
var WDGWVWindowOpen = false

if (typeof r === 'undefined') {
  function r (f) { // eslint-disable-line
    /in/.test(document.readyState) ? setTimeout(r, 9, f) : f()
  }
  if (typeof r === 'function') { }
}

function WDGWVWritePopupHTML (AlertName) {
  document.write('<div id="WDGWVdialog" class="alert-popup" style="display: none;"><div class="header-popap"></div><div class="content-popup"><img src="http://wdgwv.com/logo.png" class="logo-popup"><span class="paragraphs_area"><h6 class="domen-link"><span id="current-page">' + AlertName + '</span></h6><h6 class="paragraphs_area_title"></h6><h6 id="WDGWVpopupText" class="text">Loading...</h6></span><span class="btn_area"><button id="WDGWVbtnNO" class="active"><span>Cancel</span></button><button id="WDGWVbtnOK" class="ok"><span>OK</span></button></span></div></div><div id="WDGWVmodal" class="alert-popup" style="display: none;"><div class="header-popap"></div><div class="content-popup"><span id="modal_area" class="modal_area">Loading</span><span class="btn_area"><button id="WDGWVbtnOK" class="ok"><span>Close</span></button></span></div></div>')
}

function WDGWVWriteCSSinHTML () {
  document.write('<style type="text/css">.alert-popup{min-width:420px;min-height:156px;background:#ededed;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);overflow:hidden;vertical-align:top;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;-webkit-box-shadow:0 0 16px rgba(1,1,1,.75);-moz-box-shadow:0 0 16px rgba(1,1,1,.75);box-shadow:0 0 16px rgba(1,1,1,.75);z-index:10}.alert-popup .content-popup{background:#ececec}.alert-popup .logo-popup{height:65px;width:64px;position:absolute;top:42px;left:28px}.alert-popup .header-popap{text-align:center;font-weight:bold;width:100%;height:22px;-webkit-border-radius:8px 8px 0 0;-moz-border-radius:8px 8px 0 0;border-radius:8px 8px 0 0;background:#dbdbdb;border-bottom:1px solid #ccc}.alert-popup .paragraphs_area{display:block;padding:15px 0 0 110px;font-family:\'Arial\',sans-serif;color:#333;text-align:left}.alert-popup .modal_area{display:block;padding: 10px;font-family:\'Arial\',sans-serif;color:#333;text-align:left}.alert-popup .paragraphs_area_title,.domen-link{font-size:14px;font-weight:700;margin:0 0 7px;padding:0;border:0;vertical-align:baseline}.alert-popup .paragraphs_area .text{font-size:12px;font-weight:400;margin:0;padding:0;color:#333}.alert-popup .btn_area{margin-top: 25px;position:absolute;bottom:20px;right:20px;display:block}.alert-popup .btn_area > button{min-width:78px;max-width:140px;height:21px;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;outline:none}.alert-popup button{background:#fff;border:solid 1px #ccc;cursor:pointer;font-weight:700}.alert-popup button:hover{background:#f9f9f9}.alert-popup .active{background:#2cb5f6;color:#fff;margin-left:5px;border:none;cursor:pointer}.alert-popup .active:hover{background:#2cbff6}.alert-popup button:disabled{background:#fff;color:grey;border:solid 1px #ccc;cursor:not-allowed;font-weight:700}.alert-popup button:disabled:hover{background:#fff;color:grey;border:solid 1px #ccc;cursor:not-allowed;font-weight:700}</style>')
}

function openPopup (title, withMessage, onOk, onCancel, btn2, btn1, withTitle) {
  document.getElementById('current-page').innerHTML = title

  if (typeof withTitle !== 'undefined') {
    for (var i = 0; i < document.querySelectorAll('.header-popap').length; i++) {
      document.querySelectorAll('.header-popap')[i].innerHTML = withTitle
    }
  }

  if (typeof withMessage !== 'undefined') {
    document.getElementById('WDGWVpopupText').innerHTML = withMessage
  }

  document.getElementById('WDGWVbtnOK').onclick = function () {
    if (typeof onOk === 'function' || typeof onOk !== 'undefined') {
      setTimeout(onOk, 100)
    }

    document.getElementById('WDGWVdialog').style.display = 'none'
  }

  document.getElementById('WDGWVbtnNO').onclick = function () {
    if (typeof onCancel === 'function' || typeof onCancel !== 'undefined') {
      setTimeout(onCancel, 100)
    }

    document.getElementById('WDGWVdialog').style.display = 'none'
  }

  document.onkeydown = function (evt) {
    evt = evt || window.event
    if (evt.keyCode === 27) {
      if (typeof onCancel === 'function' || typeof onCancel !== 'undefined') {
        setTimeout(onCancel, 100)
      }
      document.getElementById('WDGWVdialog').style.display = 'none'
    }
  }

  if (typeof btn1 !== 'undefined') {
    if (btn1 === 'disabled') {
      document.getElementById('WDGWVbtnNO').disabled = true
    } else {
      document.getElementById('WDGWVbtnNO').disabled = false
    }
    if (btn1 === 'hidden') {
      document.getElementById('WDGWVbtnNO').style.display = 'none'
    } else {
      document.getElementById('WDGWVbtnNO').style.display = 'inline'
    }
    if (btn1 !== 'disabled' || btn1 !== 'hidden') {
      document.getElementById('WDGWVbtnNO').innerHTML = '<span>' + btn1 + '</span>'
    }
  }

  if (typeof btn2 !== 'undefined') {
    if (btn2 === 'disabled') {
      document.getElementById('WDGWVbtnOK').disabled = true
    } else {
      document.getElementById('WDGWVbtnOK').disabled = false
    }
    if (btn2 === 'hidden') {
      document.getElementById('WDGWVbtnOK').style.display = 'none'
    } else {
      document.getElementById('WDGWVbtnOK').style.display = 'inline'
    }
    if (btn2 !== 'disabled' || btn2 !== 'hidden') {
      document.getElementById('WDGWVbtnOK').innerHTML = '<span>' + btn2 + '</span>'
    }
  }

  if (btn1 === 'hidden' && btn2 === 'hidden') {
    document.getElementById('WDGWVdialog').style.cursor = 'progress'
  } else {
    document.getElementById('WDGWVdialog').style.cursor = 'default'
  }

  document.getElementById('WDGWVdialog').style.display = 'block'
}

function createModal (forURL, showCloseButton) {
  // ....
  // how to close.
  currentModal = true

  document.onkeydown = function (evt) {
    evt = evt || window.event
    if (evt.keyCode === 27) {
      document.getElementById('WDGWVdialog').style.display = 'none'
    }
  }
}
function closeModal (forURL) {
  // Szo
}

if (openPopup) { }
if (currentModal) { }
if (WDGWVWindowOpen) { }
if (createModal) { }
if (closeModal) { }

WDGWVWritePopupHTML('Loading')
WDGWVWriteCSSinHTML()
