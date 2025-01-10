import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import TwoFactorConfig from '@/Pages/Profile/Partials/TwoFactorConfig';
import { Head } from '@inertiajs/react';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';

function Security() {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Profile
                </h2>
            }
        >
            <Head title="Profile" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <UpdatePasswordForm />
                    </div>

                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <TwoFactorConfig />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export default Security;
