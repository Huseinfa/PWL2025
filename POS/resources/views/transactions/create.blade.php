@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Create Transaction</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" class="form-control" id="customer-name" value="Walk-in Customer">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Transaction Date</label>
                    <input type="text" class="form-control" value="{{ now()->format('d/m/Y H:i') }}" readonly>
                </div>
            </div>
        </div>

        <div class="form-group">
            <select class="form-control" id="item-select">
                <option value="">Select Item</option>
                @foreach($items as $item)
                    <option value="{{ $item->barang_id }}"
                            data-harga="{{ intval($item->harga_jual) }}"
                            data-stok="{{ $item->stok }}">
                        {{ $item->barang_nama }} (Stock: {{ $item->stok }})
                    </option>
                @endforeach
            </select>
            <button class="btn btn-primary mt-2" id="add-button">Add</button>
        </div>

        <table class="table table-bordered">
            <thead class="bg-primary">
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="items-table-body">
            </tbody>
        </table>

        <p><strong>Total:</strong> <span id="total-amount">Rp 0</span></p>

        <button class="btn btn-success" id="process-transaction">Process Transaction</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded'); // Debug: Ensure script is running

    const itemSelect = document.getElementById('item-select');
    const addButton = document.getElementById('add-button');
    const itemsTableBody = document.getElementById('items-table-body');
    const totalSpan = document.getElementById('total-amount');
    let total = 0;

    if (!addButton) {
        console.error('Add button not found');
        return;
    }

    addButton.addEventListener('click', function() {
        console.log('Add button clicked'); // Debug: Ensure click event is firing

        const selectedOption = itemSelect.options[itemSelect.selectedIndex];
        const barangId = selectedOption.value;
        const harga = parseInt(selectedOption.dataset.harga);
        const stok = parseInt(selectedOption.dataset.stok);

        console.log('Selected Item:', { barangId, harga, stok }); // Debug: Log values

        if (!barangId) {
            alert('Please select an item.');
            return;
        }

        if (isNaN(harga) || isNaN(stok)) {
            alert('Invalid price or stock value.');
            return;
        }

        const qtyInput = document.createElement('input');
        qtyInput.type = 'number';
        qtyInput.min = 1;
        qtyInput.max = stok;
        qtyInput.value = 1;
        qtyInput.className = 'form-control qty-input';
        qtyInput.style.width = '80px';

        const row = document.createElement('tr');
        row.setAttribute('data-barang-id', barangId);
        row.innerHTML = `
            <td>${selectedOption.text}</td>
            <td>Rp ${harga.toLocaleString('id-ID')}</td>
            <td></td>
            <td class="subtotal">Rp ${harga.toLocaleString('id-ID')}</td>
            <td><button class="btn btn-danger btn-sm remove-item">Remove</button></td>
        `;
        row.cells[2].appendChild(qtyInput);
        itemsTableBody.appendChild(row);

        total += harga;
        totalSpan.textContent = `Rp ${total.toLocaleString('id-ID')}`;

        qtyInput.addEventListener('change', function() {
            const qty = parseInt(this.value);
            if (qty < 1) this.value = 1;
            if (qty > stok) {
                alert(`Stock available: ${stok}`);
                this.value = stok;
            }
            const subtotal = harga * this.value;
            row.cells[3].textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            total = Array.from(document.querySelectorAll('.subtotal'))
                .reduce((sum, cell) => sum + parseInt(cell.textContent.replace(/[^0-9]/g, '')), 0);
            totalSpan.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        });

        row.querySelector('.remove-item').addEventListener('click', function() {
            row.remove();
            total = Array.from(document.querySelectorAll('.subtotal'))
                .reduce((sum, cell) => sum + parseInt(cell.textContent.replace(/[^0-9]/g, '')), 0);
            totalSpan.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        });
    });

    document.getElementById('process-transaction').addEventListener('click', function() {
        const customer = document.getElementById('customer-name').value;
        const items = Array.from(document.querySelectorAll('#items-table-body tr')).map(row => ({
            barang_id: row.getAttribute('data-barang-id'),
            jumlah: parseInt(row.cells[2].querySelector('input').value)
        }));

        if (!customer) {
            alert('Please enter a customer name.');
            return;
        }
        if (items.length === 0) {
            alert('Please add at least one item.');
            return;
        }

        fetch('{{ route("transactions.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ customer, items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = '{{ route("transactions.index") }}';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing the transaction.');
        });
    });
});
</script>
@endpush