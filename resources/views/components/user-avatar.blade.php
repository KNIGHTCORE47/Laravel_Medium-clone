@props(['size_attr' => 'w-12 h-12', 'margin_class' => 'mt-4', 'user'])

<div class="{{ $margin_class }}">
    <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="{{ $size_attr }} rounded-full object-cover">
</div>
