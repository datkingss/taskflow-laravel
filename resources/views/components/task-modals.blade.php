<x-modal name="create-task" focusable>
    <form method="post" action="{{ route('tasks.store') }}" class="p-6">
        @csrf
        <h2 class="text-lg font-bold text-white mb-4">Tạo công việc mới</h2>
        <div class="space-y-4">
            <div>
                <x-input-label for="title" value="Tiêu đề công việc" />
                <input type="text" id="title" name="title" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-900" placeholder="VD: Thiết kế giao diện..." required>
            </div>
            <div>
                <x-input-label for="description" value="Mô tả" />
                <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="status" value="Trạng thái" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="pending">Chờ xử lý</option>
                        <option value="in_progress">Đang làm</option>
                        <option value="completed">Hoàn thành</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="due_date" value="Hạn chót" />
                    <input type="date" id="due_date" name="due_date" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-900">
                </div>
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg shadow-sm">Hủy bỏ</button>
            <button type="submit" class="px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg shadow-sm">Lưu công việc</button>
        </div>
    </form>
</x-modal>

<x-modal name="edit-task" focusable>
    <div x-data="{ task: null }" @open-edit-modal.window="task = $event.detail; $dispatch('open-modal', 'edit-task')">
        <template x-if="task">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-white">Chi tiết công việc</h2>
                    <form method="POST" :action="'/tasks/' + task.id" onsubmit="return confirm('Bạn có chắc chắn muốn xóa công việc này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-1.5 rounded-md font-medium text-sm transition-colors flex items-center">
                            Xóa
                        </button>
                    </form>
                </div>
                <form method="POST" :action="'/tasks/' + task.id">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="edit_title" value="Tiêu đề công việc" />
                            <input type="text" id="edit_title" name="title" :value="task.title" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-900" required>
                        </div>
                        <div>
                            <x-input-label for="edit_description" value="Mô tả" />
                            <textarea id="edit_description" name="description" x-text="task.description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="edit_status" value="Trạng thái" />
                                <select id="edit_status" name="status" x-model="task.status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="pending">Chờ xử lý</option>
                                    <option value="in_progress">Đang làm</option>
                                    <option value="completed">Hoàn thành</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="edit_due_date" value="Hạn chót" />
                                <input type="date" id="edit_due_date" name="due_date" :value="task.due_date ? task.due_date.split('T')[0] : ''" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-white text-gray-900">
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2.5 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg">Đóng</button>
                        <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">Cập nhật</button>
                    </div>
                </form>
            </div>
        </template>
    </div>
</x-modal>