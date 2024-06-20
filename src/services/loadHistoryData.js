import { Firestore } from '@google-cloud/firestore';

const loadHistoryData = async () => {
  const db = new Firestore({
    keyFilename: process.env.GOOGLE_APPLICATION_CREDENTIALS,
    projectId: 'project-id',
    databaseId: 'project-database',
  });

  const predictCollection = db.collection('project-collection');

  const snapshot = await predictCollection.orderBy('createdAt', 'desc').get();

  const data = snapshot.docs.map((doc) => ({
    id: doc.id,
    history: doc.data(),
  }));

  return { data };
};

export default loadHistoryData;
