import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link } from '@inertiajs/react';
import { FcHighPriority } from 'react-icons/fc';

function PasswordReset() {
    return (
        <GuestLayout>
            <Head title="Reset Password" />
            <div className="flex flex-col items-center justify-center gap-x-2">
                <FcHighPriority size={150} />
                <h1 className="my-4 text-xl font-semibold text-black">
                    Invalid or expired token
                </h1>

                <Link
                    className="flex w-full items-center justify-center rounded-md bg-black py-1 text-white shadow-md"
                    href={route('login')}
                >
                    Back To Login
                </Link>
            </div>
        </GuestLayout>
    );
}

export default PasswordReset;
