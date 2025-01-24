import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { Badge, Card, Group, Text } from '@mantine/core';

export default function Dashboard() {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <Card shadow="sm" padding="lg" radius="md" withBorder>
                    <Group justify="space-between" mt="md" mb="xs">
                        <Text fw={500}>RILT Starter App</Text>
                        <Badge color="pink">V 0.0.1</Badge>
                    </Group>

                    <Text size="sm" c="dimmed">
                        Let's get started'
                    </Text>
                </Card>
            </div>
        </AuthenticatedLayout>
    );
}
