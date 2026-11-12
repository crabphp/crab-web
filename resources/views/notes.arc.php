<Layout title="Notes">
    <h1>Notes</h1>
    <Flash :message="$status" />

    <form method="post" action="/notes">
        <Input name="text" label="A note" placeholder="Write a note…" maxlength="200" required autofocus />
        <Button>Add</Button>
    </form>

    @foreach($notes as $note)
        <NoteCard :note="$note" />
    @endforeach
    @if($notes === [])
        <p class="muted">No notes yet. Add the first one above.</p>
    @endif
</Layout>
