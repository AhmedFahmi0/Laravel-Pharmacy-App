@extends('layouts.app')


@section('title') Create @endsection

@section('content')

@if ($errors->any())
<br>
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="/orders" method="POST" enctype="multipart/form-data" id="add_form">
  @csrf
  <div>
    <label for="ClientName" class="form-label">Client Name</label>
    <select id="ClientName" onchange="selectAddress()" name="ClientName" class="form-control">
        <option></option>
        @foreach($clients as $client)
            <option value="{{$client}}">{{$client->name}}</option>
        @endforeach
    </select>
  </div>
  
  <div id="show_item">
    {{-- <select id="om" class="form-control">
        <option selected="selected">orange</option>
        <option>white</option>
        <option>purple</option>
      </select> --}}
      <div class="row">
        <div class="col-md-3 mb-3 mt-3 medData">
     {{-- <input type="text" name="medicine_name[]" class="form-control" placeholder="medicine Name"> --}}
    
     <label for="MedicineName" class="form-label ">Medicine Name</label>
     <select id="MedicineName"  name="medicine_item[]" class="form-control  jqSelect  ">
            <option  ></option>
         @foreach($medicines as $medicine)
             <option    value="{{$medicine}}">{{$medicine->name}}</option>
         @endforeach
     </select>
     
        </div>
               <div class="col-md-3 mb-3 mt-3">
                <label for="MedicineQnt" class="form-label">Medicine Quantity</label>
                <input type="number" id="MedicineQnt" name="medicine_qty[]" class="form-control h-50" placeholder="medicine quantity">
                   </div>

                   <div class="col-md-3 mb-3 mt-3">
                    <label for="MedicinePrice" class="form-label">Medicine Price</label>
                    <input type="number" id="MedicinePrice" name="medicine_price[]" value="0" class="form-control medPrice h-50" placeholder="medicine price">
                    
                

                  
                            

                   
                       </div>

                   <div class="col-md-3 mb-3 mt-5">
                    <button class="btn btn-success " id="add_item_btn">Add More</button>
                   </div>
      </div>
    
  </div>

<div class="row">
 <div class="col-md-6 mb-3 mt-3">
                <label for="OrderTotalPrice" class="form-label">Is Insured</label>
                <select id="isinsured" name="is_insured" class="form-control">
                  <option ></option>
                  <option value="1">Insured</option>
                  <option value="0">Not Insured</option>
             
           </select>
                
                   </div>
                  </div>


    
    <div class="row">
      <div class="col-md-6 mb-3 mt-3">
            <label for="deliviringaddress" class="form-label">DeliviringAddress</label>
                <select id="deliviringaddress" name="deliviring_address" class="form-control" data-address ="{{$addresses}}" >
                  
                 </select>
                                 
      </div>
  </div>




 
    <div>
 
    {{-- <button type="submit" class="btn btn-success">Create</button> --}}
    <input type="submit" value="Store" class="btn btn-success w-25"  id="add_btn">
  </div>
  
  </form>
 

  <script>
 var ob =document.getElementById("MedicineName");
 var o =document.getElementById("MedicineQnt");
   var OrderTotalPrice =document.getElementById("OrderTotalPrice");
    var btn = document.getElementById("add_item_btn");
    var show_item = document.getElementById("show_item");
    btn.addEventListener("click", addMedicine);
    function addMedicine(e) {
        e.preventDefault();
      
        var newDiv = document.createElement("div");        newDiv.innerHTML = ` <div class="row medData">
      <div class="col-md-3 mb-3 mt-3">
    
    <label for="MedicineName" class="form-label ">Medicine Name</label>
    <select id="MedicineName"  name="medicine_name[]" class="form-control  jqSelect">
          <option ></option>
          @foreach($medicines as $medicine)
             <option value="{{$medicine}}">{{$medicine->name}}</option>
         @endforeach
    </select>
    
      </div>
             <div class="col-md-3 mb-3 mt-3">
              <label for="MedicineQnt" class="form-label">Medicine Quantity</label>
              <input type="number" id="MedicineQnt" name="medicine_qty[]" class="form-control h-50" placeholder="medicine quantity">
                 </div>

                 <div class="col-md-3 mb-3 mt-3">
                    <label for="MedicinePrice" class="form-label">Medicine Price</label>
                    <input type="number" id="MedicinePrice" name="medicine_price[]"  class="form-control medPrice h-50" placeholder="medicine price">
                       </div>
    
                 <div class="col-md-3 mb-3 mt-5">
                    <button class="btn btn-danger remove_item_btn">Remove</button>
                   </div>
    </div>`;
        show_item.appendChild(newDiv);
    $('.jqSelect').select2({
      tags: true,
      placeholder: "Select a medicine name",
    
    });
  

    $(".medData").on("change",".jqSelect",{},function(e){
var medprice =  JSON.parse($(this).find(":selected").val()).price;

$(this).parent().next().next().children(':first-child').next().val(medprice);

})

    }
    
    document.addEventListener("click", deleteMedicine);
    function deleteMedicine(e) {
        let tar = e.target;
        if (e.target.classList.contains("remove_item_btn")) {
            e.preventDefault();
            let inptxt = tar.parentElement.parentElement;
            inptxt.remove();
        }
    }

    
      
     
      
      function selectAddress(){
        let select = document.getElementById('ClientName');
        let deliviringaddress = document.getElementById('deliviringaddress');
        deliviringaddress.innerHTML="<option ></option>";
        let address = deliviringaddress.getAttribute("data-address");
      
        let addresses= JSON.parse(address);
       
         var clientid = JSON.parse(select.value).id;
     

       
         for(let i=0 ; i<addresses.length;i++)
         {
          if(addresses[i].client_id==clientid){
            var option = document.createElement('option'); 
            option.value = addresses[i].id;
            
            option.appendChild(document.createTextNode(addresses[i].street_name));
            
            deliviringaddress.appendChild(option);
          }

         
         }
         
      }

 

    </script>


  




@endsection