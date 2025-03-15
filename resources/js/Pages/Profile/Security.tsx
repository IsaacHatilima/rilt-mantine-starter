import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import TwoFactorConfig from '@/Pages/Profile/Partials/TwoFactorConfig';
import { User } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { Card } from '@mantine/core';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';

function Security() {
    const user: User = usePage().props.auth.user;

    return (
        <AuthenticatedLayout>
            <Head title="Profile" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <Card
                        shadow="sm"
                        padding="lg"
                        radius="md"
                        withBorder={false}
                    >
                        <UpdatePasswordForm />
                    </Card>

                    <Card
                        shadow="sm"
                        padding="lg"
                        radius="md"
                        withBorder={false}
                    >
                        <TwoFactorConfig user={user} />
                    </Card>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export default Security;
