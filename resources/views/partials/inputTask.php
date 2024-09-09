<div class="flex flex-row gap-2 task-card">
    <div class="flex flex-col gap-1">
        <label for="description">Judul To Do</label>
        <input type="text" name="description[]" placeholder="Contoh : Perbaikan api master" class="task-input">
    </div>
    <div class="flex flex-col gap-1">
        <label for="category">Kategori</label>
        <input type="text" name="category[]" placeholder="Contoh : Backend" class="task-category">
    </div>
    <button class="bg-[#F1416C] w-10 h-10 removeTaskButton">
        <x-eos-delete class="w-6 bg-[#FFFFFF]" />
    </button>
</div>
