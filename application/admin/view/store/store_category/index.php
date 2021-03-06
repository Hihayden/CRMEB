{extend name="public/container"}
{block name="content"}
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <div class="ibox-title">
                <a type="button" class="btn btn-w-m btn-primary" href="{:Url('index')}">分类首页</a>
                <button type="button" class="btn btn-w-m btn-primary" onclick="$eb.createModalFrame(this.innerText,'{:Url('create')}')">添加分类</button>
                <div class="ibox-tools">

                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="m-b m-l">
                        <form action="" class="form-inline">
                            <select name="is_show" aria-controls="editable" class="form-control input-sm">
                                <option value="">是否显示</option>
                                <option value="1" {eq name="where.is_show" value="1"}selected="selected"{/eq}>显示</option>
                                <option value="0" {eq name="where.is_show" value="0"}selected="selected"{/eq}>不显示</option>
                            </select>
                            <select name="pid" aria-controls="editable" class="form-control input-sm">
                                <option value="">所有菜单</option>
                                {volist name="cate" id="vo"}
                                <option value="{$vo.id}" {eq name="where.pid" value="$vo.id"}selected="selected"{/eq}>{$vo.html}{$vo.cate_name}</option>
                                {/volist}
                            </select>
                            <div class="input-group">
                                <input type="text" name="cate_name" value="{$where.cate_name}" placeholder="请输入分类名称" class="input-sm form-control"> <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search" ></i> 搜索</button> </span>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="table-responsive" style="overflow:visible">
                    <table class="table table-striped  table-bordered">
                        <thead>
                        <tr>

                            <th class="text-center" style="width: 40px;">编号</th>
                            <th class="text-center">父级</th>
                            <th class="text-center">分类名称</th>
                            <th class="text-center">分类图标</th>
                            <th class="text-center">排序</th>
                            <th class="text-center">是否显示</th>
                            <th class="text-center" width="5%">操作</th>
                        </tr>
                        </thead>
                        <tbody class="">
                        {volist name="list" id="vo"}
                        <tr>
                            <td class="text-center">
                                {$vo.id}
                            </td>
                            <td class="text-center">
                                {$vo.pid_name}
                            </td>
                            <td class="text-center">
                                <a href="{:Url('index',array('pid'=>$vo['id']))}"> {$vo.cate_name}</a>
                            </td>
                            <td class="text-center">
                                <img src="{$vo.pic}" alt="{$vo.cate_name}" class="open_image" data-image="{$vo.pic}" style="width: 50px;height: 50px;cursor: pointer;">
                            </td>
                            <td class="text-center">
                                {$vo.sort}
                            </td>
                            <td class="text-center">
                                <i class="fa {eq name='vo.is_show' value='1'}fa-check text-navy{else/}fa-close text-danger{/eq}"></i>
                            </td>

                            <td class="text-center">
                                <div class="input-group-btn js-group-btn" style="min-width: 106px;">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-warning btn-xs dropdown-toggle"
                                                aria-expanded="false">操作
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0);"onclick="$eb.createModalFrame('编辑','{:Url('edit',array('id'=>$vo['id']))}')">
                                                    <i class="fa fa-paste"></i> 编辑
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="delstor" data-url="{:Url('delete',array('id'=>$vo['id']))}">
                                                    <i class="fa fa-warning"></i> 删除
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {/volist}
                        </tbody>
                    </table>
                </div>
                {include file="public/inner_page"}
            </div>
        </div>
    </div>
</div>
{/block}
{block name="script"}
<script>
    $('.js-group-btn').on('click',function(){
        $('.js-group-btn').css({zIndex:1});
        $(this).css({zIndex:2});
    });
    $('.delstor').on('click',function(){
        window.t = $(this);
        var _this = $(this),url =_this.data('url');
        $eb.$swal('delete',function(){
            $eb.axios.get(url).then(function(res){
                console.log(res);
                if(res.status == 200 && res.data.code == 200) {
                    $eb.$swal('success',res.data.msg);
                    _this.parents('tr').remove();
                }else
                    return Promise.reject(res.data.msg || '删除失败')
            }).catch(function(err){
                $eb.$swal('error',err);
            });
        })
    });
    $(".open_image").on('click',function (e) {
        var image = $(this).data('image');
        $eb.openImage(image);
    })
</script>
{/block}
