import AdminAuthenticated from "@/Layouts/AdminAuthenticatedLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm } from "@inertiajs/react";
import SelectInput from "@/Components/SelectInput";
import TextAreaInput from "@/Components/TextAreaInput";

export default function Create({auth, product, brands, categories}) {
    const { data, setData, post, errors, reset } = useForm({
        name: product.name || '',
        sort: product.sort || '',
        model: product.model || '',
        price: product.price || '',
        image: '',
        banner: '',
        points: product.points || '',
        status: product.status || '',
        trending: product.trending || '',
        subtract: product.subtract || '',
        quantity: product.quantity || '',
        brand_id: product.brand_id || '',
        short_url: product.short_url || '',
        category_id: product.category_id || '',
        description: product.description || '',
        min_quantity: product.min_quantity || '',
        _method: 'PUT'
    })

    const onSubmit = (e) => {
        e.preventDefault()

        post(route('product.update', product.id))
    }

    return (
        <AdminAuthenticated
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Product "{product.name}"</h2>
                </div>
            }
        >
            <Head title="Products" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <form onSubmit={onSubmit} className="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            {product.banner && (
                                <div className="">
                                    <img src={product.banner} className="w-full h-40" />
                                </div>
                            )}
                            {product.image && (
                                <div className="flex justify-center items-center mb-4">
                                    <img src={product.image} className="w-64" />
                                </div>
                            )}

                            <div className="mt-0">
                                <InputLabel htmlFor="product_name" value="Name" />
                                <TextInput
                                    id="product_name" 
                                    type="text" 
                                    name="name"
                                    value={data.name}
                                    isFocused={true}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('name', e.target.value)}
                                />
                                <InputError message={errors.name} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="product_sort" value="Sort Order" />
                                <TextInput
                                    id="product_sort" 
                                    type="text" 
                                    name="sort"
                                    value={data.sort}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('sort', e.target.value)}
                                />
                                <InputError message={errors.sort} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="product_model" value="Model" />
                                <TextInput
                                    id="product_model" 
                                    type="text" 
                                    name="model"
                                    value={data.model}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('model', e.target.value)}
                                />
                                <InputError message={errors.model} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="product_price" value="Price" />
                                <TextInput
                                    id="product_price" 
                                    type="text" 
                                    name="price"
                                    value={data.price}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('price', e.target.value)}
                                />
                                <InputError message={errors.price} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="product_image" value="Image" />
                                <TextInput
                                    id="product_image" 
                                    type="file" 
                                    name="image"
                                    className="mt-1 block w-full"
                                    onChange={e => setData('image', e.target.files[0])}
                                />
                                <InputError message={errors.image} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="product_banner" value="Banner" />
                                <TextInput
                                    id="product_banner" 
                                    type="file" 
                                    name="banner"
                                    className="mt-1 block w-full"
                                    onChange={e => setData('banner', e.target.files[0])}
                                />
                                <InputError message={errors.banner} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="product_points" value="Points" />
                                <TextInput
                                    id="product_points" 
                                    type="text" 
                                    name="points"
                                    value={data.points}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('points', e.target.value)}
                                />
                                <InputError message={errors.points} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="product_subtract" value="Subtract Stock" />
                                <SelectInput
                                    name="subtract"
                                    id="product_subtract"
                                    defaultValue={data.subtract}
                                    className="mt-1 block w-full"
                                    onChange={(e) => setData("subtract", e.target.value)}
                                >
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </SelectInput>
                                <InputError message={errors.subtract} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="product_quantity" value="Quantity" />
                                <TextInput
                                    id="product_quantity" 
                                    type="text" 
                                    name="quantity"
                                    value={data.quantity}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('quantity', e.target.value)}
                                />
                                <InputError message={errors.quantity} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="product_minquantity" value="Min Quantity" />
                                <TextInput
                                    id="product_minquantity" 
                                    type="text" 
                                    name="min_quantity"
                                    value={data.min_quantity}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('min_quantity', e.target.value)}
                                />
                                <InputError message={errors.min_quantity} className="mt-2" />
                            </div>
                            
                            <div className="mt-4">
                                <InputLabel htmlFor="product_brand" value="Brand" />

                                <SelectInput
                                    name="brand_id"
                                    id="product_parent"
                                    defaultValue={data.brand_id}
                                    className="mt-1 block w-full"
                                    onChange={(e) => setData("brand_id", e.target.value)}
                                >
                                    <option value="0">Select Brand</option>
                                    {brands.data.map(brand => (
                                        <option value={brand.id} key={brand.id}>{brand.name}</option>
                                    ))}
                                </SelectInput>

                                <InputError message={errors.brand_id} className="mt-2" />
                            </div>
                            
                            <div className="mt-4">
                                <InputLabel htmlFor="product_category" value="Category" />

                                <SelectInput
                                    name="category_id"
                                    id="product_category"
                                    defaultValue={data.category_id}
                                    className="mt-1 block w-full"
                                    onChange={(e) => setData("category_id", e.target.value)}
                                >
                                    <option value="0">Select Category</option>
                                    {categories.data.map(category => (
                                        <option value={category.id} key={category.id}>{category.name}</option>
                                    ))}
                                </SelectInput>

                                <InputError message={errors.category_id} className="mt-2" />
                            </div>
                            
                            <div className="mt-4">
                                <InputLabel htmlFor="product_status" value="Status" />

                                <SelectInput
                                    name="status"
                                    id="product_status"
                                    className="mt-1 block w-full"
                                    defaultValue={data.status}
                                    onChange={(e) => setData("status", e.target.value)}
                                >
                                    <option value="">Select Status</option>
                                    <option value="disabled">Disabled</option>
                                    <option value="enabled">Enabled</option>
                                </SelectInput>

                                <InputError message={errors.status} className="mt-2" />
                            </div>
                            
                            <div className="mt-4">
                                <InputLabel htmlFor="product_trending" value="Trending" />

                                <SelectInput
                                    name="trending"
                                    id="product_trending"
                                    className="mt-1 block w-full"
                                    defaultValue={data.trending}
                                    onChange={(e) => setData("trending", e.target.value)}
                                >
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </SelectInput>

                                <InputError message={errors.trending} className="mt-2" />
                            </div>
                            
                            <div className="mt-4">
                                <InputLabel htmlFor="product_url" value="Short URL" />
                                <TextInput
                                    id="product_url" 
                                    type="text" 
                                    name="short_url"
                                    value={data.short_url}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('short_url', e.target.value)}
                                />
                                <InputError message={errors.short_url} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="product_description"
                                    value="Product Description"
                                />

                                <TextAreaInput
                                    id="product_description"
                                    name="description"
                                    value={data.description}
                                    className="mt-1 block w-full"
                                    onChange={(e) => setData("description", e.target.value)}
                                />

                                <InputError message={errors.description} className="mt-2" />
                            </div>

                            <div className="mt-4 text-right">
                                <Link
                                    href={route("product.index")}
                                    className="bg-gray-100 py-1 px-3 text-gray-800 rounded shadow transition-all hover:bg-gray-200 mr-2"
                                >
                                    Cancel
                                </Link>
                                <button className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AdminAuthenticated>
    )
}