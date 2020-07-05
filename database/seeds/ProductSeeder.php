<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\User;
use App\Product;
use App\Category;
use App\ProductCategory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = User::first()->id;

        // Adding ID's to map categories quickly inside products
        $categories = array(
            1 => [
                'name'  => 'Stuffed Toys',
            ],
            2 => [
                'name'  => 'Figures',
            ],
            3 => [
                'name'  => 'Pandas',
            ],
            4 => [
                'name'  => 'Minions',
            ],
        );

        $products = array(
            [
                'name'          => 'White Stuffed Panda',
                'description'   => 'Amazing white stuffed panda. The perfect toy for new-born babies.',
                'image_url'     => 'https://images.unsplash.com/photo-1544788978-bc4ae77f8119?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&h=300&q=80',
                'price'         => 12.90,
                'categories'    => [ 1, 3 ]
            ],
            [
                'name'          => 'Small Panda Figure',
                'description'   => 'Collectors edition panda figure.',
                'image_url'     => 'https://images.unsplash.com/photo-1541515808332-03ae089b8be8?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&h=300&q=80',
                'price'         => 5.00,
                'categories'    => [ 2, 3 ]
            ],
            [
                'name'          => 'Prisoner Minion Figure',
                'description'   => 'Collectors edition prisoner minion figure.',
                'image_url'     => 'https://images.unsplash.com/photo-1567722066597-2bdf36d13481?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&h=300&q=80',
                'price'         => 5.50,
                'categories'    => [ 2, 4 ]
            ],
            [
                'name'          => 'Panda-Z Figure',
                'description'   => 'Panda-Z superhero figure.',
                'image_url'     => 'https://cdn.pixabay.com/photo/2016/04/01/09/56/panda-z-1299683_960_720.jpg',
                'price'         => 5.00,
                'categories'    => [ 2, 3 ]
            ],
            [
                'name'          => 'Panda Chef',
                'description'   => 'Panda chef cooks sushi and drinks sake.',
                'image_url'     => 'https://cdn.pixabay.com/photo/2017/06/21/20/30/chef-2428451_960_720.jpg',
                'price'         => 5.90,
                'categories'    => [ 2, 3 ]
            ],
            [
                'name'          => 'Native Panda Figure',
                'description'   => 'Just a regular panda figure, nothing special.',
                'image_url'     => 'https://cdn.pixabay.com/photo/2016/08/19/20/44/panda-1606181_960_720.jpg',
                'price'         => 5.00,
                'categories'    => [ 2, 3 ]
            ],
            [
                'name'          => 'Banana-eating Minion',
                'description'   => 'Minion eating a small banana, regular minion activity.',
                'image_url'     => 'https://cdn.pixabay.com/photo/2015/08/14/19/41/minion-888797_960_720.jpg',
                'price'         => 6.20,
                'categories'    => [ 2, 4 ]
            ],
            [
                'name'          => 'Minion Holding Bear',
                'description'   => 'Minion holding a small teddy bear, cute.',
                'image_url'     => 'https://cdn.pixabay.com/photo/2016/04/19/15/13/minion-1338858_960_720.jpg',
                'price'         => 6.10,
                'categories'    => [ 2, 4 ]
            ],
        );

        DB::table('categories')->delete();
        foreach ( $categories as $index => $seed_category ) {
            $category = Category::create([
                'slug'      => Str::slug($seed_category['name']),
                'name'      => $seed_category['name'],
                'author_id' => $user_id
            ]);

            $category->save();
            $categories[$index]['db_id'] = $category->id;
        }

        DB::table('product_categories')->delete();
        DB::table('products')->delete();
        foreach ( $products as $index => $seed_product ) {
            $product = Product::create([
                'name'          => $seed_product['name'],
                'description'   => $seed_product['description'],
                'image_url'     => $seed_product['image_url'],
                'price'         => $seed_product['price'],
                'author_id'     => $user_id
            ]);

            $product->save();
            
            // Map products to categories
            foreach ( $seed_product['categories'] as $product_category ) {
                ProductCategory::create([
                    'product_id'    => $product->id,
                    'category_id'   => $categories[ $product_category ]['db_id']
                ]);
            }
        }
    }
}
