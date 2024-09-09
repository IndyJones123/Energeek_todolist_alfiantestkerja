@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="flex flex-col p-10 gap-5 ml-5 mr-5">
        <div class="flex justify-center ">
            <img class="w-full md:w-1/4 max-w-xs" src="{{asset('energeeklogo.png')}}" alt="">
        </div>
       
        <div class="flex flex-col md:flex-row gap-5 bg-[#FFFFFF] p-5 md:p-10 rounded-xl">
            <div class="flex flex-col gap-3 flex-1 ">
                <label class="font-normal">Nama</label>
                <input class="font-medium text-lg border-2 border-[#E4E6EF] p-2 rounded-lg w-full" type="text" placeholder="Nama">
            </div>
            <div class="flex flex-col gap-3 flex-1">
                <label for="Username">Username</label>
                <input class="font-medium text-lg border-2 border-[#E4E6EF] p-2 rounded-lg w-full" type="text" placeholder="Username">
            </div>
            <div class="flex flex-col gap-3 flex-1">
                <label for="Email">Email</label>
                <input class="font-medium text-lg border-2 border-[#E4E6EF] p-2 rounded-lg w-full" type="email" placeholder="Email">
            </div>
        </div>

        {{-- To Do List --}}
        <div class="flex flex-row p-5 md:p-10 ">
            <h1 class="text-xl w-5/6 items-center flex">To Do List</h1>
            <button id="addTaskButton" class="flex flex-row bg-[#FFE2E5] rounded-lg flex-1 items-center justify-center p-2 gap-3">
                <x-heroicon-s-plus class="w-6 text-[#F1416C]" />
                <h1 class="text-[#F1416C] hidden md:block">Tambah To Do</h1>
            </button>
        </div>

        {{-- Input Task Cards --}}
        <div id="taskWrapper" class="flex flex-col gap-4 p-5 md:p-10 ">
            {{-- 3 default task cards --}}
            @for ($i = 0; $i < 3; $i++)
            <div class="flex flex-col md:flex-row gap-5 task-card bg-[#ffff] md:bg-[#FAFAFA]">
                <div class="flex flex-col gap-1 w-full md:w-10/12">
                    <label for="description">Judul To Do</label>
                    <input type="text" name="description[]" placeholder="Contoh : Perbaikan api master" class="task-input p-3 border-2 border-[#E4E6EF] rounded-lg">
                </div>
                <div class="flex flex-col gap-1 flex-1 ">
                    <label for="category">Kategori</label>
                    <select name="category[]" class="task-category p-3 border-2 border-[#E4E6EF] rounded-lg">
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1 w-full md:w-12 justify-center items-center md:justify-end md:items-end ">

                    <button class="bg-[#F1416C] removeTaskButton flex items-center justify-center rounded-lg p-3">
                        <x-eos-delete class="w-6 h-6 text-[#FFFFFF]" />
                    </button>
                </div>
                

            </div>
            @endfor
            
        </div>
        <div class="flex flex-row p-5 md:p-10">
                <button type="submit" class="w-full bg-[#049C4F] rounded-xl text-[#ffff] p-3"> Simpan </button>
        </div>
        

        
    </div>

    {{-- JavaScript for dynamically adding/removing task cards --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addTaskButton = document.getElementById('addTaskButton');
            const taskWrapper = document.getElementById('taskWrapper');

            // Function to create a new task card
            function createTaskCard() {
                const taskCard = document.createElement('div');
                taskCard.classList.add('flex', 'flex-row', 'gap-5', 'task-card');

                taskCard.innerHTML = `
                                    <div class="flex flex-col gap-1 w-10/12 ">
                    <label for="description">Judul To Do</label>
                    <input type="text" name="description[]" placeholder="Contoh : Perbaikan api master" class="task-input p-3 border-2 border-[#E4E6EF] rounded-lg">
                </div>
                <div class="flex flex-col gap-1 flex-1 ">
                    <label for="category">Kategori</label>
                    <select name="category[]" class="task-category p-3 border-2 border-[#E4E6EF] rounded-lg">
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1 w-12 justify-end items-end ">

                    <button class="bg-[#F1416C] removeTaskButton flex items-center justify-center rounded-lg p-3">
                        <x-eos-delete class="w-6 h-6 text-[#FFFFFF]" />
                    </button>
                </div>
                `;

                taskWrapper.appendChild(taskCard);
            }

            // Add event listener to the "Tambah To Do" button
            addTaskButton.addEventListener('click', function (e) {
                e.preventDefault();
                createTaskCard();
            });

            // Remove task card when delete button is clicked
            taskWrapper.addEventListener('click', function (e) {
                if (e.target.closest('.removeTaskButton')) {
                    const taskCard = e.target.closest('.task-card');
                    taskWrapper.removeChild(taskCard);
                }
            });
        });
    </script>
@endsection
