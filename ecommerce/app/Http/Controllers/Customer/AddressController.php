<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->shippingAddresses()->get();
        return view('customer.addresses.index', compact('addresses'));
    }

    public function create() { return view('customer.addresses.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string',
            'last_name'    => 'required|string',
            'phone'        => 'required|string',
            'address_line1'=> 'required|string',
            'city'         => 'required|string',
            'country'      => 'required|string',
        ]);

        if ($request->boolean('is_default')) {
            auth()->user()->shippingAddresses()->update(['is_default' => false]);
        }

        auth()->user()->shippingAddresses()->create($request->all());
        return redirect()->route('customer.addresses.index')->with('success', 'Address added.');
    }

    public function edit(ShippingAddress $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);
        return view('customer.addresses.edit', compact('address'));
    }

    public function update(Request $request, ShippingAddress $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);
        $address->update($request->all());
        return redirect()->route('customer.addresses.index')->with('success', 'Address updated.');
    }

    public function destroy(ShippingAddress $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);
        $address->delete();
        return redirect()->route('customer.addresses.index')->with('success', 'Address deleted.');
    }
}
