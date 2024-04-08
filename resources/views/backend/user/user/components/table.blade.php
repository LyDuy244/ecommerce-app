<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th><input type="checkbox" id="checkAll" class="input-checkbox"></th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>SĐT</th>
        <th>Địa chỉ</th>
        <th>Nhóm thành viên</th>
        <th>Tình trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if (isset($users)  && is_object($users))
            @foreach ($users as $user)
                <tr class="row-{{ $user->id }}">
                    <td><input type="checkbox" value="{{ $user->id }}" class="input-checkbox checkBoxItem checkBoxItem-{{ $user->id }}"></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        {{ $user->address }}
                    </td>
                    <td>{{ $user->user_catalogues->name }}</td>
                    <td class="text-center ">
                        <input type="checkbox" value="{{ $user->publish }}" data-userId='{{ $user->id }}' class="js-switch publish js-switch-{{ $user->id }}" data-field='publish' data-model='User' {{ $user->publish ? 'checked' : '' }} />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route("user.delete", $user->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
            
<div>{{ $users->links() }}</div>

<script>
    const csrf_token = document.querySelector('meta[name="csrf-token"]').content
    var btnPublish = document.querySelectorAll('.publish');
    btnPublish.forEach((item)=>item.addEventListener('change', async function(e){
       let option = {
        'value': this.value,
        'model': this.dataset.model,
        'modelId': this.dataset.userid,
        'field': this.dataset.field,
        '_token': csrf_token
       }
       
        $data = await fetchData(option, '/dashboard/changeStatus')
        

        let inputValue = option.value == 1 ? 0 : 1;
        if($data.flag == true){
            this.value = inputValue;
        }
    }))

    async function fetchData(option, url) {
        const response = await fetch(url, {
                'method': 'POST',
                'headers': {
                    "content-type": "application/json",
                    "X-CSRF-TOKEN": option['_token'],
                },
                body: JSON.stringify(option)
        })
        $data = await response.json()
        return $data;
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
    const inputCheckAll = document.querySelector("#checkAll")
    const checkBoxItem = document.querySelectorAll('.checkBoxItem')

    inputCheckAll.addEventListener("click", function(e){
        let isChecked = this.checked;
        checkBoxItem.forEach((item)=>{
            item.checked=isChecked
            if(isChecked==true){
                item.closest('tr').classList.add("active-bg")
            }else{
                item.closest('tr').classList.remove("active-bg")
            }
        })
        allChecked()
    })

    checkBoxItem.forEach((item)=>item.addEventListener("click", function(){
        if(item.checked==true){
            item.closest('tr').classList.add("active-bg")
        }else{
            item.closest('tr').classList.remove("active-bg")
        }
        allChecked()
    }))

    function allChecked(){
        let allChecked =  document.querySelectorAll('.checkBoxItem:checked').length  == checkBoxItem.length;
        inputCheckAll.checked = allChecked;
    }

    const btnChangeStatus =  document.querySelectorAll('.changeStatusAll')
    btnChangeStatus.forEach(item => item.addEventListener('click', async function (e){
       e.preventDefault();

        let id = []

        checkBoxItem.forEach(item => {
            if(item.checked)
            {
               id.push(item.value);
            }
        })

        let option = {
        'value': this.dataset.value,
        'model': this.dataset.model,
        'id': id,
        'field': this.dataset.field,
        '_token': csrf_token
       }

    //    fetchData(option, '/dashboard/changeStatusAll')

       const response = await fetch('/dashboard/changeStatusAll', {
            'method': 'POST',
            'headers': {
                "content-type": "application/json",
                "X-CSRF-TOKEN": option['_token'],
            },
            body: JSON.stringify(option)
        })
        $data = await response.json()

        if($data.flag == true){
            let cssActive1 = "background-color: rgb(26, 179, 148); border-color: rgb(26, 179, 148); box-shadow: rgb(26, 179, 148) 0px 0px 0px 16px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"
            let cssActive2 = "left: 20px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"
            let cssUnActive1 = "box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; border-color: rgb(223, 223, 223); background-color: rgb(255, 255, 255); transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;"
            let cssUnActive2 = "left: 0px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"
            for(let i = 0; i < id.length; i++){
                let row = document.querySelector('.row-'+id[i])
                let jsSwitch = document.querySelector('.js-switch-'+id[i])
                let spanSwitchery = jsSwitch.nextElementSibling
                let smallSwitchery = spanSwitchery.querySelector('small')
                let checkbox = document.querySelector('.checkBoxItem-'+id[i])
                row.classList.remove('active-bg')
                if(option.value == 1){
                    spanSwitchery.setAttribute('style', cssActive1)
                    smallSwitchery.setAttribute('style', cssActive2)
                    jsSwitch.checked = true;
                }else if(option.value == 0){
                    spanSwitchery.setAttribute('style', cssUnActive1)
                    smallSwitchery.setAttribute('style', cssUnActive2)
                    jsSwitch.checked = false;
                }
                jsSwitch.value = option.value
                checkbox.checked = false;
            }
            inputCheckAll.checked = false;
        }

    }))
    }); 
</script>