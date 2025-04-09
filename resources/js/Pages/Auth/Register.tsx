import GuestLayout from '@/Layouts/GuestLayout';
import { Head, useForm, usePage } from '@inertiajs/react';
import {
    Alert,
    Button,
    Divider,
    PasswordInput,
    TextInput,
} from '@mantine/core';
import { useDisclosure } from '@mantine/hooks';
import { FormEventHandler } from 'react';
import { FcGoogle } from 'react-icons/fc';

interface SocialAuthProps {
    google: boolean;
    github: boolean;
    facebook: boolean;
}

export default function Register() {
    const [loading, { open, close }] = useDisclosure();
    const socialAuth = usePage().props.socialAuth as SocialAuthProps;
    const registrationError = usePage().props.errors;

    const { data, setData, post, errors, reset } = useForm({
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        open();
        post(route('register'), {
            onFinish: () => {
                reset('password', 'password_confirmation');
            },
            onError: () => {
                close();
            },
        });
    };

    return (
        <GuestLayout>
            <Head title="Register" />

            {registrationError.error && (
                <Alert variant="light" color="yellow" title="Warning">
                    {registrationError.error}
                </Alert>
            )}

            <form onSubmit={submit}>
                <TextInput
                    id="firstname"
                    type="text"
                    name="firstname"
                    value={data.first_name}
                    error={errors.first_name}
                    withAsterisk
                    autoComplete="firstname"
                    mt="md"
                    label="First Name"
                    placeholder="First Name"
                    onChange={(e) => setData('first_name', e.target.value)}
                    inputWrapperOrder={[
                        'label',
                        'input',
                        'description',
                        'error',
                    ]}
                />
                <TextInput
                    id="lastname"
                    type="text"
                    name="lastname"
                    value={data.last_name}
                    error={errors.last_name}
                    withAsterisk
                    autoComplete="lastname"
                    mt="md"
                    label="Last Name"
                    placeholder="Last Name"
                    onChange={(e) => setData('last_name', e.target.value)}
                    inputWrapperOrder={[
                        'label',
                        'input',
                        'description',
                        'error',
                    ]}
                />
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

                <PasswordInput
                    id="password"
                    type="password"
                    name="password"
                    value={data.password}
                    error={errors.password}
                    autoComplete="password"
                    withAsterisk
                    mt="md"
                    label="Password"
                    placeholder="Password"
                    onChange={(e) => setData('password', e.target.value)}
                    inputWrapperOrder={[
                        'label',
                        'input',
                        'description',
                        'error',
                    ]}
                />

                <PasswordInput
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    value={data.password_confirmation}
                    error={errors.password_confirmation}
                    autoComplete="password_confirmation"
                    withAsterisk
                    mt="md"
                    label="Password Confirmation"
                    placeholder="Password Confirmation"
                    onChange={(e) =>
                        setData('password_confirmation', e.target.value)
                    }
                    inputWrapperOrder={[
                        'label',
                        'input',
                        'description',
                        'error',
                    ]}
                />

                <div className="mt-4 flex flex-col items-center justify-end">
                    <Button
                        type="submit"
                        variant="filled"
                        color="black"
                        fullWidth
                        loading={loading}
                        loaderProps={{ type: 'dots' }}
                    >
                        Register
                    </Button>
                </div>
            </form>
            <Divider my="xs" label="Or" labelPosition="center" />

            <div className="mt-3 flex flex-col items-center justify-between gap-1">
                {socialAuth.google && (
                    <Button
                        variant="filled"
                        color="black"
                        fullWidth
                        onClick={() =>
                            (window.location.href = route('google.redirect'))
                        }
                    >
                        <FcGoogle size={25} />
                        <span className="ml-2">Continue with Google</span>
                    </Button>
                )}
            </div>
        </GuestLayout>
    );
}
