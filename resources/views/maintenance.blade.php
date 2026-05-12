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
                <div id="deleteBrandModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl w-full max-w-sm">

                        <h2 class="text-lg font-bold text-red-600 mb-3">Delete Brand?</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                            This action cannot be undone.
                        </p>

                        <form method="POST" id="deleteBrandForm">
                            @csrf
                            @method('DELETE')

                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="closeDeleteBrandModal()"
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
        <div id="supplierModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-md transition-opacity" onclick="closeSupplierModal()"></div>

            <div class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-3xl shadow-2xl relative z-10 border border-gray-100 dark:border-gray-700 overflow-hidden transform transition-all">
                
                <div class="px-8 pt-8 pb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 id="supplierModalTitle" class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase">
                                Add Supplier
                            </h2>
                            <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest font-semibold">Vendor Information Details</p>
                        </div>
                        <button onclick="closeSupplierModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <form method="POST" id="supplierForm" class="p-8 pt-4 space-y-5">
                    @csrf
                    <input type="hidden" name="id" id="supplier_id">

                    <div class="space-y-1">
                        <label for="supplier_name" class="block text-[10px] font-black uppercase tracking-[0.1em] text-indigo-600 dark:text-indigo-400 ml-1">
                            Supplier Name
                        </label>
                        <div class="relative">
                            <input 
                                type="text" name="supplier_name" id="supplier_name"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-transparent rounded-2xl focus:border-indigo-500 focus:bg-white dark:focus:bg-gray-800 focus:ring-0 transition-all dark:text-white placeholder-gray-400"
                                placeholder="e.g. Global Logistics Corp" required
                            >
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="contact_number" class="block text-[10px] font-black uppercase tracking-[0.1em] text-gray-400 ml-1">
                            Contact Number
                        </label>
                        <input 
                            type="text" name="contact_number" id="contact_number"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-transparent rounded-2xl focus:border-indigo-500 focus:bg-white dark:focus:bg-gray-800 focus:ring-0 transition-all dark:text-white placeholder-gray-400"
                            placeholder="+1 (555) 000-0000"
                        >
                    </div>

                    <div class="space-y-1">
                        <label for="address" class="block text-[10px] font-black uppercase tracking-[0.1em] text-gray-400 ml-1">
                            Business Address
                        </label>
                        <textarea 
                            name="address" id="address" rows="3"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border-2 border-transparent rounded-2xl focus:border-indigo-500 focus:bg-white dark:focus:bg-gray-800 focus:ring-0 transition-all dark:text-white placeholder-gray-400 resize-none"
                            placeholder="Street, City, State, ZIP"
                        ></textarea>
                    </div>

                    <div class="flex items-center gap-3 pt-4">
                        <button type="button" onclick="closeSupplierModal()"
                            class="flex-1 px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors uppercase tracking-widest">
                            Cancel
                        </button>

                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-indigo-200 dark:shadow-none transition-all active:scale-95">
                            Save Supplier
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

                        <button type="button" 
                            onclick="openDeleteSPModal({{ $sp->id }})"
                            class="text-red-600 font-bold text-xs hover:underline">
                            Delete
                        </button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div id="spModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-xl transition-opacity" onclick="closeModal()"></div>

    <div class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-[2.5rem] shadow-2xl relative z-10 border border-white/20 overflow-hidden transform transition-all">
        
        <div class="px-8 pt-8 pb-6 bg-gradient-to-b from-gray-50/50 dark:from-gray-700/30 to-transparent">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div>
                        <h2 id="modalTitle" class="text-xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Catalog Entry</h2>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Link Product to Supplier</p>
                    </div>
                </div>
                <button onclick="closeModal()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <form id="spForm" method="POST" class="p-8 pt-2 space-y-6">
            @csrf
            @method('POST')

            <div class="grid grid-cols-1 gap-5">
                <div class="space-y-1">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Select Supplier</label>
                    <div class="relative group">
                        <select name="supplier_id" id="supplier_id" 
                            class="appearance-none w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-900 border-2 border-transparent rounded-2xl focus:border-indigo-500 focus:bg-white dark:focus:bg-gray-800 transition-all dark:text-white outline-none cursor-pointer">
                            @foreach($suppliers as $s)
                                <option value="{{ $s->id }}">{{ $s->supplier_name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Select Product</label>
                    <div class="relative group">
                        <select name="product_id" id="product_id" 
                            class="appearance-none w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-900 border-2 border-transparent rounded-2xl focus:border-indigo-500 focus:bg-white dark:focus:bg-gray-800 transition-all dark:text-white outline-none cursor-pointer">
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->product_name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Cost Price (₱)</label>
                    <input type="number" step="0.01" name="cost_price" id="cost_price"
                        class="w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-900 border-2 border-transparent rounded-2xl focus:border-indigo-500 transition-all dark:text-white"
                        placeholder="0.00">
                </div>
                <div class="space-y-1">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Lead Time (Days)</label>
                    <input type="number" name="lead_time" id="lead_time"
                        class="w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-900 border-2 border-transparent rounded-2xl focus:border-indigo-500 transition-all dark:text-white"
                        placeholder="e.g. 7">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="button" onclick="closeModal()"
                    class="flex-1 px-6 py-4 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors">
                    Dismiss
                </button>
                <button type="submit"
                    class="flex-[2] px-6 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-indigo-200 dark:shadow-none transition-all active:scale-95">
                    Save Entry
                </button>
            </div>
        </form>
    </div>
</div>
<div id="deleteSPModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl w-full max-w-sm">

        <h2 class="text-lg font-bold text-red-600 mb-3">Delete Record?</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
            This action cannot be undone.
        </p>

        <form method="POST" id="deleteSPForm">
            @csrf
            @method('DELETE')

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeDeleteSPModal()"
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
    function openDeleteSPModal(id) {
        const form = document.getElementById('deleteSPForm');
        form.action = `/supplier-products/${id}`; // Sets the correct URL
        document.getElementById('deleteSPModal').classList.remove('hidden');
    }

    function closeDeleteSPModal() {
        document.getElementById('deleteSPModal').classList.add('hidden');
    }    
</script>

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