@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="flex flex-col p-10 gap-5 ml-5 mr-5">
        <div class="flex justify-center">
            <img class="w-full md:w-1/4 max-w-xs" src="{{asset('energeeklogo.png')}}" alt="">
        </div>
       
        <div class="flex flex-col md:flex-row gap-5 bg-[#FFFFFF] p-5 md:p-10 rounded-xl">
            <div class="flex flex-col gap-3 flex-1">
                <label class="font-normal">Nama</label>
                <input class="font-medium text-lg border-2 border-[#E4E6EF] p-2 rounded-lg w-full" type="text" name="name" placeholder="Nama">
            </div>
            <div class="flex flex-col gap-3 flex-1">
                <label for="Username">Username</label>
                <input class="font-medium text-lg border-2 border-[#E4E6EF] p-2 rounded-lg w-full" type="text" name="username" placeholder="Username">
            </div>
            <div class="flex flex-col gap-3 flex-1">
                <label for="Email">Email</label>
                <input class="font-medium text-lg border-2 border-[#E4E6EF] p-2 rounded-lg w-full" type="email" name="email" placeholder="Email">
            </div>
        </div>

        {{-- To Do List --}}
        <div class="flex flex-row p-5 md:p-10">
            <h1 class="text-xl w-10/12 items-center flex">To Do List</h1>
            <button id="addTaskButton" class="flex flex-row bg-[#FFE2E5] rounded-lg flex-1 items-center justify-center p-2 gap-3">
                <x-heroicon-s-plus class="w-6 text-[#F1416C]" />
                <h1 class="text-[#F1416C] hidden md:block">Tambah To Do</h1>
            </button>
        </div>

        {{-- Input Task Cards --}}
        <div id="taskWrapper" class="flex flex-col gap-4 p-5 md:p-10">
            {{-- 3 default task cards --}}
            @for ($i = 0; $i < 3; $i++)
            <div class="flex flex-col md:flex-row gap-5 task-card bg-[#ffff] md:bg-[#FAFAFA]">
                <div class="flex flex-col gap-1 w-full md:w-10/12">
                    <label for="description">Judul To Do</label>
                    <input type="text" name="description[]" placeholder="Contoh : Perbaikan api master" class="task-input p-3 border-2 border-[#E4E6EF] rounded-lg">
                </div>
                <div class="flex flex-col gap-1 flex-1">
                    <label for="category">Kategori</label>
                    <select name="category[]" class="task-category p-3 border-2 border-[#E4E6EF] rounded-lg">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1 w-full md:w-12 justify-center items-center md:justify-end md:items-end">
                    <button class="bg-[#F1416C] removeTaskButton flex items-center justify-center rounded-lg p-3">
                        <x-eos-delete class="w-6 h-6 text-[#FFFFFF]" />
                    </button>
                </div>
            </div>
            @endfor
        </div>

        <div class="flex flex-row p-5 md:p-10">
            <button id="submitTasks" type="button" class="w-full bg-[#049C4F] rounded-xl text-[#ffff] p-3">Simpan</button>
        </div>
    </div>

    {{-- Custom Modal Alert --}}
    <div id="modalAlert" class="fixed inset-0 flex items-center justify-center hidden  z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80 flex flex-col items-center justify-center text-center gap-3">
            <img id="modalIcon" src="" alt="Icon" class="w-32 h-32">
            <h2 id="modalTitle" class="text-lg font-semibold mb-4">Alert</h2>
            <p id="modalMessage" class="text-gray-700 mb-4">Your message goes here.</p>
            <button id="closeModal" class="bg-[#50CD89] text-white px-4 py-2 rounded-lg">Close</button>
        </div>
    </div>

    {{-- JavaScript for dynamically adding/removing task cards and custom alert --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addTaskButton = document.getElementById('addTaskButton');
            const taskWrapper = document.getElementById('taskWrapper');
            const submitButton = document.getElementById('submitTasks');
            const modalAlert = document.getElementById('modalAlert');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');
            const closeModalButton = document.getElementById('closeModal');
            

            function createTaskCard() {
                const taskCard = document.createElement('div');
                taskCard.classList.add('flex', 'flex-row', 'gap-5', 'task-card');

                taskCard.innerHTML = `
                    <div class="flex flex-col gap-1 w-10/12">
                        <label for="description">Judul To Do</label>
                        <input type="text" name="description[]" placeholder="Contoh : Perbaikan api master" class="task-input p-3 border-2 border-[#E4E6EF] rounded-lg">
                    </div>
                    <div class="flex flex-col gap-1 flex-1">
                        <label for="category">Kategori</label>
                        <select name="category[]" class="task-category p-3 border-2 border-[#E4E6EF] rounded-lg">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-1 w-12 justify-end items-end">
                        <button class="bg-[#F1416C] removeTaskButton flex items-center justify-center rounded-lg p-3">
                            <x-eos-delete class="w-6 h-6 text-[#FFFFFF]" />
                        </button>
                    </div>
                `;

                taskWrapper.appendChild(taskCard);
            }

            addTaskButton.addEventListener('click', function (e) {
                e.preventDefault();
                createTaskCard();
            });

            taskWrapper.addEventListener('click', function (e) {
                if (e.target.closest('.removeTaskButton')) {
                    const taskCard = e.target.closest('.task-card');
                    taskWrapper.removeChild(taskCard);
                }
            });

            submitButton.addEventListener('click', async function () {
                const taskCards = document.querySelectorAll('.task-card');
                const tasks = Array.from(taskCards).map(card => {
                    return {
                        description: card.querySelector('input[name="description[]"]').value,
                        category_id: card.querySelector('select[name="category[]"]').value
                    };
                });

                const formData = {
                    name: document.querySelector('input[name="name"]').value,
                    email: document.querySelector('input[name="email"]').value,
                    username: document.querySelector('input[name="username"]').value,
                    tasks: tasks
                };

                try {
                    const response = await axios.post('http://127.0.0.1:8000/api/task', formData);
                    showModal('Berhasil', 'To do berhasil disimpan');
                } catch (error) {
                    showModal('Gagal', 'To do gagal disimpan');
                }
            });

            function showModal(title, message) {
                const modalTitle = document.getElementById('modalTitle');
                const modalMessage = document.getElementById('modalMessage');
                const modalIcon = document.getElementById('modalIcon');
                const modalAlert = document.getElementById('modalAlert');

                modalTitle.textContent = title;
                modalMessage.textContent = message;

                // Tentukan ikon berdasarkan nilai title
                if (title === 'Berhasil') {
                    modalIcon.src = "{{ asset('check.png') }}"; // Gambar ikon berhasil
                } else if (title === 'Gagal') {
                    modalIcon.src = "{{ asset('alert.png') }}"; // Gambar ikon gagal
                }

                modalAlert.classList.remove('hidden');
                
                // Reload page after 2 seconds
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }


            closeModalButton.addEventListener('click', function () {
                modalAlert.classList.add('hidden');
            });
        });
    </script>
@endsection
