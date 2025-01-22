import GuestLayout from '@/Layouts/GuestLayout';
import { Head, useForm } from '@inertiajs/react';
import { Alert, Button, TextInput } from '@mantine/core';
import { useDisclosure } from '@mantine/hooks';
import { FormEventHandler } from 'react';

export default function ForgotPassword({ status }: { status?: string }) {
    const { data, setData, post, errors, reset } = useForm({
        email: '',
    });
    const [loading, { open, close }] = useDisclosure();

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        open();

        post(route('password.email'), {
            onFinish: () => {
                reset('email');
            },
            onError: () => {},
        });
        close();
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            <div className="mb-4 text-sm text-gray-600">
                Forgot your password? No problem. Just let us know your email
                address and we will email you a password reset link that will
                allow you to choose a new one.
            </div>

            {status && (
                <Alert variant="light" color="green" title="Success">
                    {status}
                </Alert>
            )}

            <form onSubmit={submit}>
                <TextInput
                    id="email"
                    type="email"
                    name="email"
                    value={data.email}
                    error={errors.email}
                    withAsterisk
                    autoComplete="username"
                    mt="md"
                    label="E-Mail"
                    placeholder="E-Mail"
                    onChange={(e) => setData('email', e.target.value)}
                    inputWrapperOrder={[
                        'label',
                        'input',
                        'description',
                        'error',
                    ]}
                />

                <div className="mt-4 flex items-center justify-center">
                    <Button
                        type="submit"
                        variant="filled"
                        color="black"
                        fullWidth
                        loading={loading}
                        loaderProps={{ type: 'dots' }}
                    >
                        Email Password Reset Link
                    </Button>
                </div>
            </form>
        </GuestLayout>
    );
}
