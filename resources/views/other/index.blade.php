@extends('layouts.app')
@section('additional_css')
    <style>
        .zoom{
            transition: transform .2s;
        }
        .zoom:hover{
            transform: scale(1.1);
        }
        .pointer:hover{
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="alert alert-success d-none text-center" role="alert" id="alert">
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <p>Other products</p>
                            </div>
                            @if(auth()->user()->is_admin)
                                <div class="col-6">
                                    <a href="{{route('other.create')}}" class="float-end  btn btn-outline-primary">Add new</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-body" id="prodDiv">

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you really want to delete this product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <form action="" id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button  class="btn btn-primary" >Yes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additional_script')
    <script>
        async function getAllProducts(){
            let response = await fetch("{{route('others.get')}}");
            let products = await response.json();
            let prodDivHTML = ``;
            let types = [];
            products.forEach((product) => {
                if(!(product['type'] in types)){
                    prodDivHTML += filterFunction(products, product['type']);
                    types.push(product['type']);
                }
            });
            document.getElementById('prodDiv').innerHTML = prodDivHTML;
        }
        function filterFunction(products, product_type){
            let type_div = `<div class="row mt-3"><p>${product_type}s</p></div>`;
            products.forEach((product) =>{
                if(product['type'] == product_type){
                    type_div += `    <div class="row mt-1 zoom">
                                        <div class="col-2 ps-5">${product['name']}</div>
                                        <div class="col-1">${product['price']} ???</div>
                                        <div class="col-4">${product['description']}</div>
                                        <div class="col-2"><img src="http://127.0.0.1:8000/storage/${product['path']}" class="img-thumbnail" alt=""></div>
                                        <div class="col-2 ps-5 pointer" onclick="addProduct(${product['id']})" ><i class="fa-solid fa-basket-shopping fa-2xl"></i></div>
                                        @if(auth()->user()->is_admin)
                                            <div class="col-1 pe-5">
                                                <i class="fa-solid fa-pen pointer" onclick="editProduct(${product['id']})"></i>
                                                <i class="fa-solid fa-trash pt-2 pointer" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="openDeleteModal(${product['id']})"></i>
                                            </div>
                                        @endif
                                     </div>`;
                }
            });
            return type_div;
        }

        async function addProduct(product_id){
            let result = await fetch(`/other/add/${product_id}`);
            let resultJson = await result.json();
            let alertText = 'Item added to your bag!';
            if(resultJson['status']){
                displayAlert(alertText);
            }else{
                alertText = 'Item is already in your bag!'
                displayAlert(alertText);
            }
        }

        function displayAlert(alertText){
            let alert = document.getElementById('alert');
            alert.innerHTML = alertText;
            alert.classList.remove('d-none');
            setTimeout(()=>{
                alert.classList.add('d-none');
            }, 2000);
        }

        function editProduct(id){
            window.location = `/other/${id}/edit`;
        }
        function openDeleteModal(id){
            document.getElementById('deleteForm').action = `/other/${id}`;
        }

        getAllProducts();
    </script>
@endsection
