<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8, target-densitydpi=low-dpi"/>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/Public/assets/admin/css/font.css">
    <link rel="stylesheet" href="/Public/assets/admin/css/xadmin.css">
    <script type="text/javascript" src="/Public/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="/Public/assets/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/Public/assets/admin/js/xadmin.js"></script>
    <script src="/Public/assets/js/popper.min.js"></script>
    <script src="/Public/assets/js/bootstrap.min.js"></script>
    <script src="/Public/assets/js/dialog.min.js"></script>
    <link rel="stylesheet" href="/Public/dist/css/bootstrap.min.css">
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">贷款管理</a>
        <a>
          <cite>贷款人审核</cite></a>
      </span>
      <a class="layui-btn layui-btn-small flush" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
          <input type="text" name="name"  placeholder="请输入贷款人姓名" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach" id="search"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>

      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th style="display: none;">订单id</th>
            <th style="display: none;">用户id</th>
            <th>借款单编号</th>
            <th>贷款金额</th>
            <th>借款人姓名</th>
            <th>借款人电话</th>
            <th>还款方式</th>
            <th>期限</th>
            <th>利息</th>
            <th>手续费</th>
            <th>用途</th>
            <th>提交审核时间</th>
            <th style="display: none">到期时间</th>
            <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                <td>
                  <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td style="display: none;"><?php echo ($val["loan_id"]); ?></td>
                <td style="display: none;"><?php echo ($val["id"]); ?></td>
                <td><a title="审核"  onclick="x_admin_show('查看','checkLoan/?loan_id=<?php echo ($val["loan_id"]); ?>&id=<?php echo ($val["id"]); ?>')" href="javascript:;"><?php echo (strtotime($val["create_time"])); ?></a></td>
                <td><?php echo ($val["sum"]); ?></td>
                <td><?php echo ($val["name"]); ?></td>
                <td><?php echo ($val["number"]); ?></td>
                <td><?php echo ($val["method"]); ?></td>
                <td><?php echo ($val["deadline"]); ?></td>
                <td><?php echo ($val["interest"]); ?></td>
                <td><?php echo ($val["poundage"]); ?></td>
                <td><?php echo ($val["use"]); ?></td>
                <td><?php echo ($val["create_time"]); ?></td>
                <td style="display: none"><?php echo ($val["dead_time"]); ?></td>
                <td class="td-manage">
                  <!-- <a title="审核"  onclick="x_admin_show('编辑','checkLoan/?loan_id=<?php echo ($val["loan_id"]); ?>&uid=<?php echo ($val["uid"]); ?>')" href="javascript:;">
                    <i class="layui-icon">&#xe63c;</i>
                  </a>
                  <a title="删除" onclick="member_del(this,'要删除的id')" href="javascript:;">
                    <i class="layui-icon">&#xe640;</i>
                  </a> -->
                  <button class="btn btn-primary btn-sm yes" ><a title="通过" style="text-decoration:none; color: white;" onclick="yes(this,'要删除的id')" href="javascript:;">通过</a></button>
                  <button class="btn btn-danger btn-sm no"><a title="驳回" style="text-decoration:none; color: white;" onclick="no(this,'要删除的id')" href="javascript:;">驳回</a></button>
                </td>
              </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
      </table>
      <div class="page">
        <div>
          <!-- <a class="prev" href="">&lt;&lt;</a>
          <a class="num" href="">1</a>
          <span class="current">2</span>
          <a class="num" href="">3</a>
          <a class="num" href="">489</a>
          <a class="next" href="">&gt;&gt;</a> -->
        </div>
      </div>

    </div>
    <script>
      layui.use('laydate', function(){
        var laydate = layui.laydate;
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });

       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
              }
              
          });
      }

      /*用户-通过*/
      function yes(obj,id){
          layer.confirm('确认通过吗？',function(index){
            var loan_id = $(obj).parent().parent().parent().find('td').eq(1).text();
              //发异步删除数据
              $.ajax({
                url: "<?php echo U('/admin/admin/yes');?>",
                type: "post",
                dataType: "json",
                data: {
                    loan_id: loan_id,
                },
                success: function(data){

                }
              })
              $(obj).parents("tr").remove();
              layer.msg('已通过!',{icon:1,time:1000});
          });
      }

      function no(obj,id){
        layer.confirm('确认驳回吗？',function(index){
            var loan_id = $(obj).parent().parent().parent().find('td').eq(1).text();
              //发异步删除数据
              $.ajax({
                url: "<?php echo U('/admin/admin/no');?>",
                type: "post",
                dataType: "json",
                data: {
                    loan_id: loan_id,
                },
                success: function(data){
                    console.log(data.info);
                }
              })
              $(obj).parents("tr").remove();
              layer.msg('已驳回!',{icon:1,time:1000});
          });
      }



      function delAll (argument) {

        var data = tableCheck.getData();
  
        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }
    </script>

    <script>
    
    </script>
  </body>

</html>