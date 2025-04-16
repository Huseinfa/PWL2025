@extends('layouts.template')

   @section('content')
   <div class="card card-outline card-primary">
       <div class="card-header">
           <h3 class="card-title">Transaction History</h3>
       </div>
       <div class="card-body">
           @if($transactions->isEmpty())
               <p>No transactions found.</p>
           @else
               <div class="table-responsive">
                   <table class="table table-bordered table-striped">
                       <thead class="bg-primary">
                           <tr>
                               <th>Transaction Code</th>
                               <th>Date</th>
                               <th>Customer</th>
                               <th>Total</th>
                               <th>Cashier</th>
                               <th>Details</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach($transactions as $transaction)
                               <tr>
                                   <td>{{ $transaction->penjualan_kode }}</td>
                                    <td>
                                        @if($transaction->penjualan_tanggal instanceof \Carbon\Carbon)
                                            {{ $transaction->penjualan_tanggal->format('d/m/Y H:i') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($transaction->penjualan_tanggal)->format('d/m/Y H:i') }}
                                        @endif
                                    </td>
                                   <td>{{ $transaction->customer }}</td>
                                   <td>Rp {{ number_format($transaction->total_harga, 2, ',', '.') }}</td>
                                   <td>{{ $transaction->user->username }}</td>
                                   <td>
                                       <button class="btn btn-info btn-sm view-details" 
                                               data-toggle="modal" 
                                               data-target="#detailsModal" 
                                               data-details='@json($transaction->details)'>
                                           View
                                       </button>
                                   </td>
                               </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
           @endif
       </div>
   </div>

   <!-- Modal for Transaction Details -->
   <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Transaction Details</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="modal-body">
                   <table class="table">
                       <thead>
                           <tr>
                               <th>Item</th>
                               <th>Price</th>
                               <th>Qty</th>
                               <th>Subtotal</th>
                           </tr>
                       </thead>
                       <tbody id="modal-details-body">
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>
   @endsection

   @push('scripts')
   <script>
   document.addEventListener('DOMContentLoaded', function() {
       document.querySelectorAll('.view-details').forEach(button => {
           button.addEventListener('click', function() {
               const details = JSON.parse(this.dataset.details);
               const tbody = document.getElementById('modal-details-body');
               tbody.innerHTML = '';

               details.forEach(detail => {
                   tbody.innerHTML += `
                       <tr>
                           <td>${detail.barang.barang_nama}</td>
                           <td>Rp ${detail.harga.toLocaleString('id-ID')}</td>
                           <td>${detail.jumlah}</td>
                           <td>Rp ${detail.subtotal.toLocaleString('id-ID')}</td>
                       </tr>
                   `;
               });
           });
       });
   });
   </script>
   @endpush