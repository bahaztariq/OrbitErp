<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Client;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\CalenderEvent;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CompanyOneSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Company 1 exists
        $company = Company::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Orbit Corp',
                'slug' => 'orbit-corp',
                'description' => 'A premier modern ERP solution provider.',
                'is_active' => true,
            ]
        );

        // 2. Ensure Test User exists and is associated with Company 1
        $user = User::updateOrCreate(
            ['email' => 'admin@orbitcorp.com'],
            [
                'name' => 'Orbit Admin',
                'password' => bcrypt('password'),
            ]
        );

        // Associate user with company if not already
        if (!$user->companies()->where('companies.id', 1)->exists()) {
            $user->companies()->attach(1);
        }

        // 3. Create Categories
        $categories = [
            'Electronics', 'Software', 'Services', 'Hardware'
        ];

        foreach ($categories as $catName) {
            Category::updateOrCreate(
                ['name' => $catName, 'company_id' => 1]
            );
        }

        $categoryIds = Category::where('company_id', 1)->pluck('id')->toArray();

        // 4. Create Products
        $productsData = [
            ['name' => 'Cloud Hosting Plus', 'price' => 199.99],
            ['name' => 'Legacy CRM Support', 'price' => 500.00],
            ['name' => 'ERP Premium License', 'price' => 1200.00],
            ['name' => 'Data Migration Service', 'price' => 2500.00],
            ['name' => 'Security Audit', 'price' => 1500.00],
        ];

        foreach ($productsData as $pData) {
            Product::updateOrCreate(
                ['name' => $pData['name'], 'company_id' => 1],
                [
                    'price' => $pData['price'],
                    'sku' => strtoupper(Str::random(8)),
                    'category_id' => $categoryIds[array_rand($categoryIds)],
                    'description' => 'High-quality ' . $pData['name'] . ' for enterprise needs.',
                ]
            );
        }

        $productIds = Product::where('company_id', 1)->pluck('id')->toArray();

        // 5. Create Clients
        $clientsData = [
            ['name' => 'TechNova Solutions', 'email' => 'contact@technova.com'],
            ['name' => 'Global Logistics Inc', 'email' => 'billing@globallogistics.com'],
            ['name' => 'Alpha Software Ltd', 'email' => 'sales@alphasoft.com'],
            ['name' => 'Blue Sky Agency', 'email' => 'support@bluesky.com'],
        ];

        foreach ($clientsData as $cData) {
            Client::updateOrCreate(
                ['email' => $cData['email'], 'company_id' => 1],
                [
                    'name' => $cName = $cData['name'],
                    'phone' => '123-456-7890',
                    'address' => '123 ' . $cName . ' St',
                    'city' => 'Enterprise City',
                    'country' => 'USA',
                ]
            );
        }

        $clientIds = Client::where('company_id', 1)->pluck('id')->toArray();

        // 6. Create Orders, OrderItems, Invoices, and Payments
        foreach ($clientIds as $clientId) {
            for ($i = 0; $i < 2; $i++) {
                $order = Order::create([
                    'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                    'status' => 'delivered',
                    'client_id' => $clientId,
                    'company_id' => 1,
                    'created_by' => $user->id,
                ]);

                // Add 1-3 items to order
                $totalAmount = 0;
                $numItems = rand(1, 3);
                $selectedProducts = array_rand(array_flip($productIds), $numItems);
                if (!is_array($selectedProducts)) $selectedProducts = [$selectedProducts];

                foreach ($selectedProducts as $prodId) {
                    $product = Product::find($prodId);
                    $qty = rand(1, 5);
                    $price = $product->price;
                    $itemTotal = $price * $qty;
                    $totalAmount += $itemTotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $prodId,
                        'quantity' => $qty,
                        'price' => $price,
                    ]);
                }

                // Create Invoice
                $invoice = Invoice::create([
                    'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                    'order_id' => $order->id,
                    'client_id' => $clientId,
                    'issue_date' => Carbon::now()->subDays(rand(1, 30)),
                    'due_date' => Carbon::now()->addDays(rand(1, 30)),
                    'total_amount' => $totalAmount,
                    'status' => 'paid',
                    'company_id' => 1,
                ]);

                // Create Payment
                Payment::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $totalAmount,
                    'payment_date' => Carbon::now(),
                    'payment_method' => 'Credit Card',
                    'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
                    'company_id' => 1,
                ]);
            }
        }

        // 7. Create Calendar Events
        $events = [
            ['title' => 'Client Kickoff Meeting', 'type' => 'meeting'],
            ['title' => 'Quarterly Review', 'type' => 'internal'],
            ['title' => 'Product Launch', 'type' => 'milestone'],
        ];

        foreach ($events as $event) {
            CalenderEvent::create([
                'title' => $event['title'],
                'event_date' => Carbon::now()->addDays(rand(1, 10)),
                'company_id' => 1,
            ]);
        }

        // 8. Create Tasks
        $taskData = [
            'Review Q1 Financials',
            'Update Client Onboarding Flow',
            'Prepare Demo for TechNova',
            'Fix CSS alignment in Dashboard',
        ];

        foreach ($taskData as $tTitle) {
            Task::create([
                'title' => $tTitle,
                'description' => 'Important task related to ' . $tTitle,
                'status' => 'pending',
                'priority' => 'high',
                'company_id' => 1,
                'assigned_to' => $user->id,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(3),
            ]);
        }
    }
}
