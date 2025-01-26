import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import TwoFactorConfig from '@/Pages/Profile/Partials/TwoFactorConfig';
import { Head } from '@inertiajs/react';
import { Card } from '@mantine/core';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';

function Security() {
    return (
        <AuthenticatedLayout>
            <Head title="Profile" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <Card shadow="sm" padding="lg" radius="md" withBorder>
                        <UpdatePasswordForm />
                    </Card>

                    <Card shadow="sm" padding="lg" radius="md" withBorder>
                        <TwoFactorConfig />
                    </Card>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export default Security;
