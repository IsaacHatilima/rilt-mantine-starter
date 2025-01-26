import { Link } from '@inertiajs/react';
import { Card, Container } from '@mantine/core';
import { PropsWithChildren } from 'react';
import Logo from '../Components/Logo';

export default function Guest({ children }: PropsWithChildren) {
    return (
        <Container className="flex min-h-screen flex-col items-center pt-6 sm:justify-center sm:pt-0">
            <div>
                <Link href="/">
                    <Logo />
                </Link>
            </div>

            <Card
                shadow="sm"
                radius="md"
                withBorder
                className="mt-6 w-full overflow-hidden shadow-md sm:max-w-md sm:rounded-lg"
            >
                {children}
            </Card>
        </Container>
    );
}
