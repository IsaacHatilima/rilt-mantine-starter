import Logo from '@/Components/Logo';
import { Link } from '@inertiajs/react';
import { Card } from '@mantine/core';
import { PropsWithChildren } from 'react';

export default function Guest({ children }: PropsWithChildren) {
    return (
        <div className="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0">
            <div>
                <Link href="/">
                    <Logo />
                </Link>
            </div>

            <Card
                shadow="sm"
                radius="md"
                withBorder
                className="mt-6 w-full overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg"
            >
                {children}
            </Card>
        </div>
    );
}
