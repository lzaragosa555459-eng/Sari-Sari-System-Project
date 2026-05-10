<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Maintenance') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- BRANDS --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Brands</h3>
                            <p class="text-xs text-gray-500">Manage product manufacturers and brand names.</p>
                        </div>

                        <button 
                            onclick="openBrandModal()"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95 shadow-md shadow-indigo-100 dark:shadow-none">
                            + Add Brand
                        </button>
                    </div>

                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] uppercase font-black text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Brand Name</th>
                                <th class="px-4 py-3">Created</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($brands as $brand)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-4 py-4 font-mono text-xs text-gray-400">#{{ $brand->id }}</td>
                                    <td class="px-4 py-4 font-bold text-gray-900 dark:text-white">{{ $brand->brand_name }}</td>
                                    <td class="px-4 py-4 text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($brand->created_at)->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 py-4 text-right space-x-3">
                                        <button 
                                            onclick="openBrandModal(@js($brand))"
                                            class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-tighter">
                                            Edit
                                        </button>

                                        <button 
                                            onclick="openDeleteBrand({{ $brand->id }})"
                                            class="text-red-600 hover:text-red-900 font-bold text-xs uppercase tracking-tighter">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $brands->links() }}
                    </div>
                </div>

                {{-- BRAND MODAL (Modernized) --}}
                <div id="brandModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeBrandModal()"></div>
                    <div class="bg-white dark:bg-gray-800 w-full max-w-md p-8 rounded-3xl shadow-2xl relative z-10 border border-gray-100 dark:border-gray-700">
                        
                        <h2 id="brandModalTitle" class="text-xl font-black mb-6 text-gray-800 dark:text-white uppercase tracking-tighter border-b pb-2">Add Brand</h2>

                        <form method="POST" id="brandForm" class="space-y-4">
                            @csrf
                            <div id="methodField"></div> {{-- Placeholder for PUT method --}}

                            <div>
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Brand Name</label>
                                <input type="text" name="brand_name" id="brand_name"
                                    class="w-full mt-1 p-3 bg-gray-50 dark:bg-gray-700 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 dark:text-white"
                                    placeholder="e.g. Nike, Samsung"
                                    required>
                            </div>

                            <div class="flex justify-end gap-3 pt-4">
                                <button type="button" onclick="closeBrandModal()"
                                    class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl font-bold text-sm">
                                    Cancel
                                </button>

                                <button type="submit"
                                    class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 dark:shadow-none transition-transform active:scale-95">
                                    Save Brand
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- DELETE MODAL (Modernized) --}}
                <div id="deleteBrandModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeDeleteBrandModal()"></div>
                    <div class="bg-white dark:bg-gray-800 w-full max-w-sm p-8 rounded-3xl shadow-2xl relative z-10 text-center">
                        <div class="w-16 h-16 bg-red-50 dark:bg-red-900/20 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </div>
                        
                        <h2 class="text-xl font-black text-gray-800 dark:text-white uppercase tracking-tighter">Are you sure?</h2>
                        <p class="text-sm text-gray-500 mt-2">This action cannot be undone. This brand will be permanently removed.</p>

                        <form method="POST" id="deleteBrandForm" class="mt-6 flex gap-3">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="closeDeleteBrandModal()"
                                class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl font-bold text-sm">
                                No, Keep it
                            </button>
                            <button class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-red-200 dark:shadow-none transition-transform active:scale-95">
                                Yes, Delete
                            </button>
                        </form>
                    </div>
                </div>
            <script>
            function openBrandModal(data = null) {
                const modal = document.getElementById('brandModal');
                const form = document.getElementById('brandForm');
                const title = document.getElementById('brandModalTitle');

                modal.classList.remove('hidden');

                if (data) {
                    title.innerText = "Edit Brand";

                    document.getElementById('brand_name').value = data.brand_name;

                    form.action = "/brands/" + data.id;

                    // change method to PUT
                    form.querySelector('input[name="_method"]').value = "PUT";

                } else {
                    title.innerText = "Add Brand";

                    document.getElementById('brand_name').value = "";

                    form.action = "/brands";

                    // reset method to POST
                    form.querySelector('input[name="_method"]').value = "POST";
                }
            }

            function closeBrandModal() {
                document.getElementById('brandModal').classList.add('hidden');
            }

            function openDeleteBrand(id) {
                document.getElementById('deleteBrandModal').classList.remove('hidden');
                document.getElementById('deleteBrandForm').action = "/brands/" + id;
            }

            function closeDeleteBrandModal() {
                document.getElementById('deleteBrandModal').classList.add('hidden');
            }
            </script>
            {{-- CATEGORIES --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Categories</h3>
                        <p class="text-xs text-gray-500">Organize your inventory by groupings.</p>
                    </div>
                    <button 
                        onclick="openCategoryModal()"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95">
                        + Add Category
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] uppercase tracking-widest font-black text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Category Name</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($categories as $cat)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-4 py-4 font-mono text-xs text-gray-400">#{{ $cat->id }}</td>
                                    <td class="px-4 py-4 font-bold text-gray-900 dark:text-white">{{ $cat->category_name }}</td>
                                    <td class="px-4 py-4 text-right space-x-2">
                                        <div class="flex justify-end gap-2">

                                            <button 
                                                onclick="openCategoryModal(@js($cat))"
                                                class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase">
                                                Edit
                                            </button>

                                            <button 
                                                onclick="openDeleteCategory({{ $cat->id }})"
                                                class="text-red-600 hover:text-red-900 font-bold text-xs uppercase">
                                                Delete
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
            <div id="categoryModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl p-6">

                    <h2 id="categoryModalTitle" class="text-lg font-bold mb-4 text-gray-900 dark:text-white">
                        Add Category
                    </h2>

                    <form method="POST" id="categoryForm">
                        @csrf
                        <input type="hidden" name="_method" id="category_method" value="POST">

                        <input type="hidden" name="id" id="category_id">

                        <label class="text-sm text-gray-600">Category Name</label>
                        <input type="text" name="category_name" id="category_name"
                            class="w-full mt-1 mb-4 rounded-lg dark:bg-gray-700 dark:text-white"
                            required>

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeCategoryModal()"
                                class="px-4 py-2 bg-gray-300 rounded-lg">
                                Cancel
                            </button>

                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                                Save
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            <div id="deleteCategoryModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl w-full max-w-sm">

                    <h2 class="text-lg font-bold text-red-600 mb-3">Delete Category?</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                        This action cannot be undone.
                    </p>

                <form method="POST" id="deleteBrandForm>
                    @csrf
                    @method('DELETE')

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeDeleteCategoryModal()"
                                class="px-4 py-2 bg-gray-300 rounded-lg">
                                Cancel
                            </button>

                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg">
                                Delete
                            </button>
                        </div>

                    </form>

                </div>
            </div>
            <script>
            function openCategoryModal(data = null) {
                document.getElementById('categoryModal').classList.remove('hidden');

                let form = document.getElementById('categoryForm');
                let methodField = document.getElementById('category_method');

                if (data) {
                    // EDIT
                    document.getElementById('categoryModalTitle').innerText = "Edit Category";

                    document.getElementById('category_id').value = data.id;
                    document.getElementById('category_name').value = data.category_name;

                    form.action = "/categories/" + data.id;
                    methodField.value = "PUT";

                } else {
                    // ADD
                    document.getElementById('categoryModalTitle').innerText = "Add Category";

                    document.getElementById('category_id').value = "";
                    document.getElementById('category_name').value = "";

                    form.action = "/categories";
                    methodField.value = "POST";
                }
            }

            function closeCategoryModal() {
                document.getElementById('categoryModal').classList.add('hidden');
            }

            function openDeleteCategory(id) {
                document.getElementById('deleteCategoryModal').classList.remove('hidden');
                document.getElementById('deleteCategoryForm').action = "/categories/" + id;
            }

            function closeDeleteCategoryModal() {
                document.getElementById('deleteCategoryModal').classList.add('hidden');
            }
            </script>
            {{-- SUPPLIERS --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Suppliers</h3>
                        <p class="text-xs text-gray-500">Contact information for your vendors.</p>
                    </div>
                    <button 
                        onclick="openSupplierModal()"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95">
                        + Add Supplier
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] uppercase tracking-widest font-black text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-4 py-3">Supplier</th>
                                <th class="px-4 py-3">Contact</th>
                                <th class="px-4 py-3">Address</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($suppliers as $sup)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-4 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $sup->supplier_name }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono">ID: #{{ $sup->id }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-600 dark:text-gray-400 font-medium">{{ $sup->contact_number }}</td>
                                    <td class="px-4 py-4 text-gray-500 text-xs max-w-xs truncate">{{ $sup->address }}</td>
                                    <td class="px-4 py-4 text-right space-x-2">
                                        <div class="flex justify-end gap-2">

                                            <button 
                                                onclick="openSupplierModal(@js($sup))"
                                                class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase">
                                                Edit
                                            </button>

                                            <button 
                                                onclick="openDeleteSupplier({{ $sup->id }})"
                                                class="text-red-600 hover:text-red-900 font-bold text-xs uppercase">
                                                Delete
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $suppliers->links() }}
                </div>
            </div>
        </div>
        <div id="supplierModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl p-6">

                <h2 id="supplierModalTitle" class="text-lg font-bold mb-4 text-gray-900 dark:text-white">
                    Add Supplier
                </h2>

                <form method="POST" id="supplierForm">
                    @csrf

                    <input type="hidden" name="id" id="supplier_id">

                    {{-- Supplier Name --}}
                    <label class="text-sm">Supplier Name</label>
                    <input 
                        type="text" 
                        name="supplier_name" 
                        id="supplier_name"
                        class="w-full mb-3 rounded-lg dark:bg-gray-700 dark:text-white"
                        required
                    >

                    {{-- Contact --}}
                    <label class="text-sm">Contact Number</label>
                    <input 
                        type="text" 
                        name="contact_number" 
                        id="contact_number"
                        class="w-full mb-3 rounded-lg dark:bg-gray-700 dark:text-white"
                    >

                    {{-- Address --}}
                    <label class="text-sm">Address</label>
                    <textarea 
                        name="address" 
                        id="address"
                        class="w-full mb-4 rounded-lg dark:bg-gray-700 dark:text-white"
                    ></textarea>

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeSupplierModal()"
                            class="px-4 py-2 bg-gray-300 rounded-lg">
                            Cancel
                        </button>

                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                            Save
                        </button>
                    </div>

                </form>

            </div>
        </div>
        <div id="deleteSupplierModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl w-full max-w-sm">

                <h2 class="text-lg font-bold text-red-600 mb-3">Delete Supplier?</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    This will remove all related supplier records.
                </p>

                <form method="POST" id="deleteSupplierForm">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeDeleteSupplierModal()"
                            class="px-4 py-2 bg-gray-300 rounded-lg">
                            Cancel
                        </button>

                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg">
                            Delete
                        </button>
                    </div>

                </form>

            </div>
        </div>
        <script>
        function openSupplierModal(data = null) {
            document.getElementById('supplierModal').classList.remove('hidden');

            if (data) {
                // EDIT
                document.getElementById('supplierModalTitle').innerText = "Edit Supplier";

                document.getElementById('supplier_id').value = data.id;
                document.getElementById('supplier_name').value = data.supplier_name;
                document.getElementById('contact_number').value = data.contact_number;
                document.getElementById('address').value = data.address;

                document.getElementById('supplierForm').action = "/suppliers/update";
            } else {
                // ADD
                document.getElementById('supplierModalTitle').innerText = "Add Supplier";

                document.getElementById('supplier_id').value = "";
                document.getElementById('supplierForm').reset();

                document.getElementById('supplierForm').action = "/suppliers/store";
            }
        }

        function closeSupplierModal() {
            document.getElementById('supplierModal').classList.add('hidden');
        }

        function openDeleteSupplier(id) {
            document.getElementById('deleteSupplierModal').classList.remove('hidden');
            document.getElementById('deleteSupplierForm').action = "/suppliers/delete/" + id;
        }

        function closeDeleteSupplierModal() {
            document.getElementById('deleteSupplierModal').classList.add('hidden');
        }
        </script>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
{{-- SUPPLIER PRODUCTS --}}
<div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">
                Supplier Product Catalog
            </h3>
            <p class="text-xs text-gray-500">
                Mapping products to their respective suppliers and costs.
            </p>
        </div>

        <button onclick="openAdd()"
            class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold">
            + Add Product Entry
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-[10px] uppercase tracking-widest font-black text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-4 py-3">Supplier</th>
                    <th class="px-4 py-3">Product</th>
                    <th class="px-4 py-3">Cost Price</th>
                    <th class="px-4 py-3">Lead Time</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($supplierProducts as $sp)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">

                    <td class="px-4 py-4 font-bold text-gray-900 dark:text-white">
                        {{ $sp->supplier_name }}
                    </td>

                    <td class="px-4 py-4 text-gray-600 dark:text-gray-400">
                        {{ $sp->product_name }}
                    </td>

                    <td class="px-4 py-4">
                        <span class="px-2 py-1 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-md font-bold text-xs">
                            ₱{{ number_format($sp->cost_price, 2) }}
                        </span>
                    </td>

                    <td class="px-4 py-4 text-gray-500 text-xs">
                        <span class="font-medium text-gray-700 dark:text-gray-300">
                            {{ $sp->lead_time }}
                        </span> days
                    </td>

                    <td class="px-4 py-4 text-right space-x-3">

                        <button onclick='openEdit(@json($sp))'
                            class="text-indigo-600 font-bold text-xs">
                            Edit
                        </button>

                        <form action="/supplier-products/{{ $sp->id }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Delete this record?')"
                                class="text-red-600 font-bold text-xs">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div id="spModal"
    class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white dark:bg-gray-800 w-full max-w-lg p-6 rounded-2xl">

        <div class="flex justify-between mb-4">
            <h2 id="modalTitle" class="text-lg font-black text-white">Add Entry</h2>
            <button onclick="closeModal()" class="text-white text-xl">×</button>
        </div>

        <form id="spForm" method="POST">
            @csrf
            @method('POST')

            {{-- Supplier --}}
            <select name="supplier_id" id="supplier_id" class="w-full mb-3 p-2 rounded">
                @foreach($suppliers as $s)
                    <option value="{{ $s->id }}">{{ $s->supplier_name }}</option>
                @endforeach
            </select>

            {{-- Product --}}
            <select name="product_id" id="product_id" class="w-full mb-3 p-2 rounded">
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->product_name }}</option>
                @endforeach
            </select>

            <input type="number" step="0.01" name="cost_price" id="cost_price"
                placeholder="Cost Price" class="w-full mb-3 p-2 rounded">

            <input type="number" name="lead_time" id="lead_time"
                placeholder="Lead Time (days)" class="w-full mb-3 p-2 rounded">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-400 rounded-xl">
                    Cancel
                </button>

                <button class="px-4 py-2 bg-indigo-600 text-white rounded-xl">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
<script>
/* =========================
   OPEN ADD MODAL
========================= */
function openAdd() {
    const form = document.getElementById('spForm');

    form.action = '/supplier-products';

    // Laravel method spoofing
    setMethod('POST');

    document.getElementById('modalTitle').innerText = 'Add Entry';

    // reset fields
    document.getElementById('supplier_id').value = '';
    document.getElementById('product_id').value = '';
    document.getElementById('cost_price').value = '';
    document.getElementById('lead_time').value = '';

    document.getElementById('spModal').classList.remove('hidden');
}

/* =========================
   OPEN EDIT MODAL
========================= */
function openEdit(sp) {
    const form = document.getElementById('spForm');

    form.action = '/supplier-products/' + sp.id;

    // IMPORTANT: must be PUT for update route
    setMethod('PUT');

    document.getElementById('modalTitle').innerText = 'Edit Entry';

    // fill fields safely
    document.getElementById('supplier_id').value = sp.supplier_id ?? '';
    document.getElementById('product_id').value = sp.product_id ?? '';
    document.getElementById('cost_price').value = sp.cost_price ?? '';
    document.getElementById('lead_time').value = sp.lead_time ?? '';

    document.getElementById('spModal').classList.remove('hidden');
}

/* =========================
   CLOSE MODAL
========================= */
function closeModal() {
    document.getElementById('spModal').classList.add('hidden');
}

/* =========================
   METHOD SWITCHER (IMPORTANT FIX)
   This is what prevents your 405 error
========================= */
function setMethod(method) {
    let methodInput = document.querySelector('#spForm input[name="_method"]');

    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        document.getElementById('spForm').appendChild(methodInput);
    }

    methodInput.value = method;
}

/* =========================
   OPTIONAL: ESC KEY CLOSE MODAL
========================= */
document.addEventListener('keydown', function (e) {
    if (e.key === "Escape") {
        closeModal();
    }
});

/* =========================
   OPTIONAL: CLICK OUTSIDE TO CLOSE
========================= */
document.getElementById('spModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
            </div>
        </div>

    </div>
</x-app-layout>