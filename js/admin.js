let btnList = document.getElementsByClassName("ban");
let unListBtn = document.getElementsByClassName("Unban");
let deleBtn = document.getElementsByClassName("delete");
let upAdmin = document.getElementsByClassName("m-a");
let rAdmin = document.getElementsByClassName("r-a");



let selector21 = 0;

Array.from(btnList).forEach(btn => {
    btn.addEventListener('click', () => {

        let Bi = btn.id;
        let selector = document.querySelector(`#${Bi} > input`).value;
        let overlay = document.querySelector(".overlay");

        selector21 = selector;
        overlay.style.display = "flex";

        });
});

Array.from(unListBtn).forEach(btn => {
    btn.addEventListener('click', () => {
        let Bo = btn.id;
        let selector11 = document.querySelector(`#${Bo} > input`).value;

        $.post('../controllers/un.php', {
            id: selector11
        }, function (data) {
            window.location.reload();
        });
    })
})

let form = document.getElementById("cococococo");
let banGO = document.getElementById("goTime");
let close = document.getElementById("close");

form.onsubmit = function(e) {
    e.preventDefault();
}

banGO.addEventListener('click', () => {
    let banTime = parseInt(document.getElementById("ban_time").value);
    let reason = document.getElementById("ban_res").value;
    let overlay = document.querySelector(".overlay");

    if (banTime >= 5 && banTime <= 15 && reason !== "") {
        $.post('functions/ban.php', {
            id: selector21,
            time: banTime,
            res: reason

        }, function(data) {
            overlay.style.display = "none";
            window.location.reload();
        });
    } else {
        document.getElementById("ban_res").value = "";
        document.getElementById("ban_time").value = "";
    }
});

close.addEventListener('click', () => {
    let overlay = document.querySelector(".overlay");
    overlay.style.display = "none";
});


setInterval(() => {
    $.ajax({
        url: '../controllers/bansetter.php',
        success: function (data) {

        }
    })
}, 60000)


Array.from(deleBtn).forEach(btn => {
    btn.addEventListener('click', () => {
        let By = btn.id;
        let selector17 = document.querySelector(`#${By} > input`).value;

        $.post('functions/delete.php', {
            id: selector17
        }, function (data) {
            window.location.reload();
        });
    });
});

Array.from(upAdmin).forEach(btn => {
    btn.addEventListener('click', () => {
        let Bg = btn.id;
        let selector216 = document.querySelector(`#${Bg} > input`).value;

        $.post('functions/m_admin.php', {
            id: selector216
        }, function (data) {
            window.location.reload();
        });
    });
});

Array.from(rAdmin).forEach(btn => {
    btn.addEventListener('click', () => {
        let Bp = btn.id;
        let selector601 = document.querySelector(`#${Bp} > input`).value;

        $.post('functions/r_admin.php', {
            id: selector601
        }, function (data) {
            window.location.reload();
        });
    });
});

let postsBtn = document.getElementsByClassName('goPost');
let DelBtn = document.getElementsByClassName('delete4');
let editC = document.getElementsByClassName("comnt");
let closer = document.getElementById("close2");
let save = document.getElementById("gocomm");
let comment = document.getElementById("comm_desc");
let dComment = document.getElementsByClassName("comnt_d");
let req = 0;


closer.addEventListener("click", () => {
    let overblow = document.querySelector(".overlay5");
    overblow.style.display = "none";
});

save.addEventListener('click', () => {
    if (comment.value != "" && req != 0) {
        let overblow = document.querySelector(".overlay5");
        $.post('functions/edit_comment.php', {
            id: req,
            comment: comment.value
        }, function (data) {
            window.location.reload();
        });
    } else {
        document.getElementById("comm_desc").value = "";
    }
});

Array.from(postsBtn).forEach(btn => {
    btn.addEventListener('click', () => {
        let Bb = btn.id;
        let selector60 = document.querySelector(`#${Bb} > input`).value;
        window.location.href = `../pages/post.php?post_id=${selector60}`;
    });
});

Array.from(DelBtn).forEach(btn => {
    btn.addEventListener('click', () => {
        let Bb = btn.id;
        let selector60 = document.querySelector(`#${Bb} > input`).value;
        
        $.post('functions/delete_post.php', {
            id: selector60
        }, function (data) {
            window.location.reload();
        });
    });
});


Array.from(editC).forEach(btn => {
    btn.addEventListener('click', () => {
        let Bl = btn.id;
        let cID = document.querySelector(`#${Bl} > input`).value;
        let overblow = document.querySelector(".overlay5");
        overblow.style.display = "flex";
        req = cID;
    });
});

Array.from(dComment).forEach(btn => {
    btn.addEventListener('click', () => {
        let Bm = btn.id;
        let cID2 = document.querySelector(`#${Bm} > input`).value;

        $.post('functions/delete_comment.php', {
            id: cID2
        }, function (data) {
            window.location.reload();
        });
            
    });
});

let edit_msg = document.getElementsByClassName("editMSG");
let dele_msg = document.getElementsByClassName("deleMSG");
let newMsg = document.getElementById("msg_dec");
let saveing = document.getElementById("gomsg");
let closing = document.getElementById("close3");
let req2 = 0;



closing.addEventListener("click", () => {
    let overblow2 = document.querySelector(".overlay4");
    overblow2.style.display = "none";

});

saveing.addEventListener("click", () => {
    if (newMsg.value !== "" && req2 !== 0) {
        $.post('functions/edit_msg.php', {
            id: req2,
            msg: newMsg.value
        }, function (data) {
            // console.log(data)
            window.location.reload();
        });
    } else {
        newMsg.value = "";
    }
});

Array.from(edit_msg).forEach(btn => {
    btn.addEventListener('click', () => {
        let iBm = btn.id;
        let cID22 = document.querySelector(`#${iBm} > input`).value;
        let overblow2 = document.querySelector(".overlay4");
        
        req2 = cID22;
        overblow2.style.display = "flex";
    });
});


Array.from(dele_msg).forEach(btn => {
    btn.addEventListener('click', () => {
        let kBm = btn.id;
        let cID3 = document.querySelector(`#${kBm} > input`).value;

        $.post('functions/dele_msg.php', {
            id: cID3
        }, function (data) {
            window.location.reload();
        }); 
    });
});

let pUser = document.getElementsByClassName("goCurrent");
let pFollower = document.getElementsByClassName("goFollow"); 


Array.from(pUser).forEach(btn => {
    btn.addEventListener('click', () => {
        let Bb = btn.id;
        let select = document.querySelector(`#${Bb} > input`).value;
        window.location.href = `../pages/profile.php?profile_id=${select}`;
    });
});

Array.from(pFollower).forEach(btn => {
    btn.addEventListener('click', () => {
        let Bk = btn.id;
        let selecto = document.querySelector(`#${Bk} > input`).value;
        window.location.href = `../pages/profile.php?profile_id=${selecto}`;
    });
});

let report = document.getElementsByClassName("ropo");

Array.from(report).forEach(btn => {
    btn.addEventListener('click', () => {
        let Be = btn.id;
        let selecto11 = document.querySelector(`#${Be} > input`).value;

        $.post("functions/fin_repo.php", {
            id: selecto11
        }, function () {
            window.location.reload();
        })
    });
});