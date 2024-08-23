import AdminAuthenticated from "@/Layouts/AdminAuthenticatedLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm } from "@inertiajs/react";
import SelectInput from "@/Components/SelectInput";

export default function Create({auth}) {
    const { data, setData, post, errors, reset } = useForm({
        name: '',
        sort: '',
        image: '',
        status: '',
        short_url: ''
    })

    const onSubmit = (e) => {
        e.preventDefault()

        post(route('brand.store'))
    }

    return (
        <AdminAuthenticated
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create New Brand</h2>
                </div>
            }
        >
            <Head title="Brands" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <form onSubmit={onSubmit} className="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            <div className="mt-0">
                                <InputLabel htmlFor="brand_name" value="Name" />
                                <TextInput
                                    id="brand_name" 
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
                                <InputLabel htmlFor="brand_image" value="Image" />
                                <TextInput
                                    id="brand_image" 
                                    type="file" 
                                    name="image"
                                    className="mt-1 block w-full"
                                    onChange={e => setData('image', e.target.files[0])}
                                />
                                <InputError message={errors.image} className="mt-2" />
                            </div>
                            
                            <div className="mt-4">
                                <InputLabel htmlFor="brand_sort" value="Sort Order" />
                                <TextInput
                                    id="brand_sort" 
                                    type="text" 
                                    name="sort"
                                    value={data.sort}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('sort', e.target.value)}
                                />
                                <InputError message={errors.sort} className="mt-2" />
                            </div>
                            
                            <div className="mt-4">
                                <InputLabel htmlFor="brand_status" value="Status" />

                                <SelectInput
                                    name="status"
                                    id="brand_status"
                                    className="mt-1 block w-full"
                                    onChange={(e) => setData("status", e.target.value)}
                                >
                                    <option value="">Select Status</option>
                                    <option value="disabled">Disabled</option>
                                    <option value="enabled">Enabled</option>
                                </SelectInput>

                                <InputError message={errors.status} className="mt-2" />
                            </div>
                            
                            <div className="mt-4">
                                <InputLabel htmlFor="brand_url" value="Short URL" />
                                <TextInput
                                    id="brand_url" 
                                    type="text" 
                                    name="short_url"
                                    value={data.short_url}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('short_url', e.target.value)}
                                />
                                <InputError message={errors.short_url} className="mt-2" />
                            </div>

                            <div className="mt-4 text-right">
                                <Link
                                    href={route("brand.index")}
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