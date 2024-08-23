import AdminAuthenticated from "@/Layouts/AdminAuthenticatedLayout";
import Pagination from "@/Components/Pagination";
import { Head, Link, router } from '@inertiajs/react';
import TextInput from "@/Components/TextInput";
import SelectInput from "@/Components/SelectInput";
import TableHeading from "@/Components/TableHeading";

export default function Index({auth, products, brands, queryParams = null, success}) {
    queryParams = queryParams || {}
    const searchFieldChanged = (name, value) => {
        if (value) {
            queryParams[name] = value
        } else {
            delete queryParams[name]
        }

        router.get(route('product.index'), queryParams)
    }

    const onKeyPress = (name, e) => {
        if (e.key !== 'Enter') return;

        searchFieldChanged(name, e.target.value);
    }

    const sortChanged = (name) => {
        if (name === queryParams.field) {
            if (queryParams.direction === 'asc') {
                queryParams.direction = 'desc';
            } else {
                queryParams.direction = 'asc';
            }
        } else {
            queryParams.field = name;
            queryParams.direction = 'asc';
        }
        router.get(route('product.index'), queryParams)
    }

    const deleteUser = (product) => {
        if (!window.confirm("Are you sure you want to delete this product?")) {
            return;
        }

        router.delete(route("product.destroy", product.id))
    }

    return (
        <AdminAuthenticated
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Products</h2>
                    <Link 
                        href={route('product.create')} 
                        className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600"
                    >
                        Add New
                    </Link>
                </div>
            }
        >
            <Head title="Products" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {success && (
                        <div className="bg-emerald-500 py-2 px-4 text-white rounded mb-4">
                            {success}
                        </div>
                    )}

                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="overflow-auto">
                                <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr className="text-nowrap">
                                            <TableHeading 
                                                name="id" 
                                                field={queryParams.field} 
                                                direction={queryParams.direction}
                                                sortChanged={sortChanged}
                                            >
                                                ID
                                            </TableHeading>
                                            <TableHeading 
                                                name="name" 
                                                field={queryParams.field} 
                                                direction={queryParams.direction}
                                                sortChanged={sortChanged}
                                            >
                                                Name
                                            </TableHeading>
                                            <TableHeading 
                                                name="model" 
                                                field={queryParams.field} 
                                                direction={queryParams.direction}
                                                sortChanged={sortChanged}
                                            >
                                                Model
                                            </TableHeading>
                                            <th className="px-3 py-3">Price</th>
                                            <th className="px-3 py-3">Image</th>
                                            <TableHeading 
                                                name="brand_id" 
                                                field={queryParams.field} 
                                                direction={queryParams.direction}
                                                sortChanged={sortChanged}
                                            >
                                                Brand
                                            </TableHeading>
                                            <TableHeading 
                                                name="status" 
                                                field={queryParams.field} 
                                                direction={queryParams.direction}
                                                sortChanged={sortChanged}
                                            >
                                                Status
                                            </TableHeading>
                                            <th className="px-3 py-3">Url</th>
                                            <th className="px-3 py-3">Sort</th>
                                            <TableHeading 
                                                name="created_at" 
                                                field={queryParams.field} 
                                                direction={queryParams.direction}
                                                sortChanged={sortChanged}
                                            >
                                                Create Date
                                            </TableHeading>
                                            <th className="px-3 py-3 text-right">Actions</th>
                                        </tr>
                                    </thead>

                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-3"></th>
                                            <th className="px-3 py-3">
                                                <TextInput 
                                                    className="w-full" 
                                                    defaultValue={queryParams.name}
                                                    placeholder="Name"
                                                    onBlur={e => searchFieldChanged('name', e.target.value)}
                                                    onKeyPress={e => onKeyPress('name', e)}
                                                />
                                            </th>
                                            <th className="px-3 py-3">
                                                <TextInput 
                                                    className="w-full" 
                                                    defaultValue={queryParams.model}
                                                    placeholder="Model"
                                                    onBlur={e => searchFieldChanged('model', e.target.value)}
                                                    onKeyPress={e => onKeyPress('model', e)}
                                                />
                                            </th>
                                            <th className="px-3 py-3"></th>
                                            <th className="px-3 py-3"></th>
                                            <th className="px-3 py-3">
                                                <SelectInput 
                                                    className="w-full"
                                                    defaultValue={queryParams.brand_id}
                                                    onChange={e => searchFieldChanged('brand_id', e.target.value)}
                                                >
                                                    <option value="">Select Brand</option>
                                                    {brands.data.map(brand => (
                                                        <option value={brand.id} key={brand.id}>{brand.name}</option>
                                                    ))}
                                                </SelectInput>
                                            </th>
                                            <th className="px-3 py-3">
                                                <TextInput 
                                                    className="w-full" 
                                                    defaultValue={queryParams.status}
                                                    placeholder="Status"
                                                    onBlur={e => searchFieldChanged('status', e.target.value)}
                                                    onKeyPress={e => onKeyPress('status', e)}
                                                />
                                            </th>
                                            <th className="px-3 py-3"></th>
                                            <th className="px-3 py-3"></th>
                                            <th className="px-3 py-3"></th>
                                            <th className="px-3 py-3"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {products.data.map(product => (
                                            <tr
                                            key={product.id} 
                                                className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <th className="px-3 py-2">{product.id}</th>
                                                <th className="px-3 py-2 text-gray-700">
                                                    {product.name}
                                                </th>
                                                <th className="px-3 py-2 text-gray-700">
                                                    {product.model}
                                                </th>
                                                <th className="px-3 py-2 text-gray-700">
                                                    {product.price}
                                                </th>
                                                <td className="px-3 py-2">
                                                    <img src={product.image} style={{width:60}} />
                                                </td>
                                                <td className="px-3 py-2 text-nowrap">
                                                    {product.brand ? product.brand.name : '' }
                                                </td>
                                                <td className="px-3 py-2 capitalize text-nowrap">{product.status}</td>
                                                <td className="px-3 py-2">{product.short_url}</td>
                                                <td className="px-3 py-2">{product.sort}</td>
                                                <td className="px-3 py-2 text-nowrap">{product.created_at}</td>
                                                <td className="px-3 py-2 text-nowrap">
                                                    <Link href={route('product.edit', product.id)} className="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1">
                                                        Edit
                                                    </Link>
                                                    <button onClick={(e) => deleteUser(product)} className="font-medium text-red-600 dark:text-red-500 hover:underline mx-1">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                            <Pagination links={products.meta.links} />
                        </div>
                    </div>
                </div>
            </div>
        </AdminAuthenticated>
    )
}