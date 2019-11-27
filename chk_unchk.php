<script src="/js/jquery-1.12.4.min.js"></script>
<input type="checkbox" id="AllChack" name="chk" value="1">전체선택<br>
<input type="checkbox" class="argee_chk" name="chk" value="0">
<input type="checkbox" class="argee_chk" name="chk" value="1">
<input type="checkbox" class="argee_chk" name="chk" value="2">
<input type="checkbox" class="argee_chk" name="chk" value="3">
<input type="checkbox" class="argee_chk" name="chk" value="4">
<input type="checkbox" class="argee_chk" name="chk" value="5">
<button id="btn1">기수선택</button>
<button id="btn2">우수선택</button>
<button id="btn3">선택된값</button>
<script>
$(document).ready(function(){
    $("#AllChack").click(function(){
        if($("#AllChack").prop('checked')==true) {
            $(".argee_chk").prop('checked',true);
        }else{
            $(".argee_chk").prop('checked',false);
        }
    });
    $(".argee_chk").click(function(){
        chkCnt = $(".argee_chk").length;
        if($(this).prop('checked') == false) {
            $("#AllChack").prop('checked', false) ;
        }else if($(".argee_chk:checkbox:checked").length == chkCnt){
            $("#AllChack").prop('checked', true) ;
        }
    });

    $("#btn1").click(function(){
        $("#AllChack").prop('checked', false) ;
        $(".argee_chk").prop('checked',false);
        $(".argee_chk:odd").prop("checked",true);
    });

    $("#btn2").click(function(){
        $("#AllChack").prop('checked', false) ;
        $(".argee_chk").prop('checked',false);
        $(".argee_chk:even").prop("checked",true);
    });
    $("#btn3").click(function(){
        var aa="";
        $(".argee_chk:checkbox:checked").each(function(){
            aa+=$(this).val()
        });
        console.log(aa);
    });



});
</script>
